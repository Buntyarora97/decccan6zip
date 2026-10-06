/* Site-wide language selector backed by the project's curated translations. */
(function () {
  'use strict';

  const widget = document.getElementById('languageSwitcher');
  if (!widget) return;

  const toggle = document.getElementById('languageToggle');
  const menu = document.getElementById('languageMenu');
  const currentLabel = document.getElementById('languageCurrent');
  const status = document.getElementById('languageStatus');
  const choices = Array.from(widget.querySelectorAll('[data-language]'));
  const files = [
    'shared.json',
    'static-pages.json',
    'patient-pages.json',
    'clinical-data.json',
    'department-local-1.json',
    'department-local-2.json',
    'department-local-3.json',
    'other-local.json'
  ];
  const labels = { en: 'EN', hi: 'हि', mr: 'म' };
  const languageNames = { en: 'English', hi: 'Hindi', mr: 'Marathi' };
  const textRecords = new WeakMap();
  const attributeRecords = new WeakMap();
  let dictionaries = null;
  let dictionariesPromise = null;
  let activeLanguage = 'en';
  let originalTitle = document.title;

  function openMenu(open) {
    menu.hidden = !open;
    toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
  }

  function isTranslatableNode(node) {
    const parent = node.parentElement;
    return !!parent && !parent.closest(
      '#languageSwitcher, script, style, noscript, svg, code, pre, [translate="no"]'
    );
  }

  function reverseLookup(language, value) {
    if (!dictionaries || !dictionaries[language]) return value;
    const reverse = dictionaries[language].reverse;
    return reverse[value] || value;
  }

  function translateTextNode(node) {
    if (!isTranslatableNode(node)) return;

    const value = node.nodeValue;
    const record = textRecords.get(node);
    let source = record && value === record.output
      ? record.source
      : value;

    if (activeLanguage === 'en') {
      if (record && value === record.output) node.nodeValue = record.source;
      return;
    }

    if (!dictionaries || !dictionaries[activeLanguage]) return;
    if (!record || value !== record.output) source = reverseLookup(activeLanguage, source.trim()) === source.trim()
      ? source
      : reverseLookup(activeLanguage, source.trim());

    const trimmed = source.trim();
    const translated = dictionaries[activeLanguage].forward[trimmed];
    if (!translated || translated === trimmed) return;

    const leading = source.match(/^\s*/)[0];
    const trailing = source.match(/\s*$/)[0];
    const output = leading + translated + trailing;
    textRecords.set(node, { source: source, output: output });
    if (node.nodeValue !== output) node.nodeValue = output;
  }

  function translateAttribute(element, attribute) {
    const value = element.getAttribute(attribute);
    if (value === null) return;

    let records = attributeRecords.get(element);
    if (!records) {
      records = Object.create(null);
      attributeRecords.set(element, records);
    }
    const record = records[attribute];
    let source = record && value === record.output ? record.source : value;

    if (activeLanguage === 'en') {
      if (record && value === record.output) element.setAttribute(attribute, record.source);
      return;
    }
    if (!dictionaries || !dictionaries[activeLanguage]) return;

    if (!record || value !== record.output) source = reverseLookup(activeLanguage, source.trim()) === source.trim()
      ? source
      : reverseLookup(activeLanguage, source.trim());
    const translated = dictionaries[activeLanguage].forward[source.trim()];
    if (!translated || translated === source.trim()) return;

    records[attribute] = { source: source, output: translated };
    if (value !== translated) element.setAttribute(attribute, translated);
  }

  function translateElement(element) {
    if (!(element instanceof Element) || element.closest('#languageSwitcher, [translate="no"]')) return;
    ['alt', 'title', 'aria-label', 'placeholder'].forEach(function (attribute) {
      translateAttribute(element, attribute);
    });
    if (element.matches('input[type="submit"], input[type="button"]')) {
      translateAttribute(element, 'value');
    }
  }

  function translatePage() {
    document.documentElement.lang = activeLanguage;
    if (activeLanguage === 'en') {
      document.title = originalTitle;
    } else if (dictionaries && dictionaries[activeLanguage]) {
      document.title = dictionaries[activeLanguage].forward[originalTitle] || originalTitle;
    }

    const walker = document.createTreeWalker(document.body, NodeFilter.SHOW_TEXT);
    let node;
    while ((node = walker.nextNode())) translateTextNode(node);
    document.body.querySelectorAll('*').forEach(translateElement);
    choices.forEach(function (choice) {
      choice.setAttribute('aria-pressed', choice.dataset.language === activeLanguage ? 'true' : 'false');
    });
    currentLabel.textContent = labels[activeLanguage];
  }

  function loadDictionaries() {
    if (dictionariesPromise) return dictionariesPromise;
    dictionariesPromise = Promise.all(files.map(function (file) {
      return fetch(widget.dataset.dictionaryBase + file, { credentials: 'same-origin' }).then(function (response) {
        if (!response.ok) throw new Error('Translation file unavailable: ' + file);
        return response.json();
      });
    })).then(function (filesData) {
      const result = { hi: { forward: Object.create(null), reverse: Object.create(null) }, mr: { forward: Object.create(null), reverse: Object.create(null) } };
      filesData.forEach(function (fileData) {
        ['hi', 'mr'].forEach(function (language) {
          Object.assign(result[language].forward, fileData[language] || {});
        });
      });
      ['hi', 'mr'].forEach(function (language) {
        Object.keys(result[language].forward).forEach(function (english) {
          const translated = result[language].forward[english];
          if (translated && !result[language].reverse[translated]) result[language].reverse[translated] = english;
        });
      });
      dictionaries = result;
      return result;
    }).catch(function (error) {
      dictionariesPromise = null;
      throw error;
    });
    return dictionariesPromise;
  }

  function chooseLanguage(language) {
    if (!labels[language]) return;
    openMenu(false);
    if (language === activeLanguage) {
      toggle.focus();
      return;
    }

    const applyChoice = function () {
      activeLanguage = language;
      try {
        localStorage.setItem('dm-language', language);
      } catch (error) {
        // Keep the selection for this page even when browser storage is unavailable.
      }
      translatePage();
      status.textContent = 'Language changed to ' + languageNames[language] + '.';
      toggle.focus();
    };

    if (language === 'en') {
      applyChoice();
      return;
    }
    status.textContent = 'Loading ' + languageNames[language] + ' translations.';
    loadDictionaries().then(applyChoice).catch(function () {
      status.textContent = 'Translations could not be loaded. Please try again.';
      openMenu(true);
    });
  }

  toggle.addEventListener('click', function () {
    openMenu(menu.hidden);
  });
  choices.forEach(function (choice) {
    choice.addEventListener('click', function () {
      chooseLanguage(choice.dataset.language);
    });
  });
  document.addEventListener('click', function (event) {
    if (!widget.contains(event.target)) openMenu(false);
  });
  document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape' && !menu.hidden) {
      openMenu(false);
      toggle.focus();
    }
  });

  const observer = new MutationObserver(function (mutations) {
    if (activeLanguage === 'en') return;
    mutations.forEach(function (mutation) {
      if (mutation.type === 'characterData') {
        translateTextNode(mutation.target);
      } else if (mutation.type === 'attributes') {
        translateAttribute(mutation.target, mutation.attributeName);
      } else {
        mutation.addedNodes.forEach(function (added) {
          if (added.nodeType === Node.TEXT_NODE) {
            translateTextNode(added);
          } else if (added.nodeType === Node.ELEMENT_NODE && !added.closest('#languageSwitcher')) {
            translateElement(added);
            const walker = document.createTreeWalker(added, NodeFilter.SHOW_TEXT);
            let textNode;
            while ((textNode = walker.nextNode())) translateTextNode(textNode);
            added.querySelectorAll('*').forEach(translateElement);
          }
        });
      }
    });
  });
  observer.observe(document.body, {
    subtree: true,
    childList: true,
    characterData: true,
    attributes: true,
    attributeFilter: ['alt', 'title', 'aria-label', 'placeholder', 'value']
  });

  let savedLanguage = 'en';
  try {
    const stored = localStorage.getItem('dm-language');
    if (labels[stored]) savedLanguage = stored;
  } catch (error) {
    // English remains the default when browser storage is unavailable.
  }
  if (savedLanguage !== 'en') {
    loadDictionaries().then(function () {
      activeLanguage = savedLanguage;
      translatePage();
    }).catch(function () {
      status.textContent = 'Translations could not be loaded. Please choose a language to try again.';
    });
  } else {
    document.documentElement.lang = 'en';
  }
})();