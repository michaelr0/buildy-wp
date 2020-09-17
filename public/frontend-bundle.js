/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/js/components/accordion.js":
/*!****************************************!*\
  !*** ./src/js/components/accordion.js ***!
  \****************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _util_debounce__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../util/debounce */ \"./src/js/util/debounce.js\");\n\n\nclass Accordion {\n  constructor(el, settings) {\n    this.group = el;\n    this.accordionItems = this.group.getElementsByClassName(\"accordion\");\n    this.toggles = this.group.getElementsByClassName(\"accordion-title\");\n    this.contents = this.group.getElementsByClassName(\"accordion-body\");\n\n    if (!this.group || !this.accordionItems || !this.toggles || !this.contents) {\n      return;\n    } // Set default settings if necessary\n\n\n    this.settings = {\n      speed: 300,\n      one_visible: false,\n      ...settings\n    }; // Setup inital positions\n\n    this.sizeAccordions();\n    window.addEventListener('resize', Object(_util_debounce__WEBPACK_IMPORTED_MODULE_0__[\"default\"])(() => this.sizeAccordions(), 50)); // Setup click handler\n\n    this.group.addEventListener(\"click\", e => {\n      if (e.target.classList.contains(\"accordion-title\")) {\n        e.preventDefault();\n        let num = 0;\n\n        for (let i = 0; i < this.toggles.length; i++) {\n          if (this.toggles[i] === e.target) {\n            num = i;\n            break;\n          }\n        }\n\n        if (!e.target.parentNode.hasAttribute(\"open\")) {\n          this.open(num);\n        } else {\n          this.close(num);\n        }\n      }\n    });\n  }\n\n  sizeAccordions() {\n    if (!this.accordionItems) {\n      return;\n    }\n\n    for (let i = 0; i < this.accordionItems.length; i++) {\n      const item = this.accordionItems[i];\n      const toggle = this.toggles[i];\n      const content = this.contents[i]; // Set transition-duration to match JS setting\n\n      item.style.transitionDuration = this.settings.speed + \"ms\"; // Set initial height to transition from\n\n      if (!item.hasAttribute(\"open\")) {\n        item.style.height = toggle.clientHeight + \"px\";\n      } else {\n        item.style.height = toggle.clientHeight + content.clientHeight + \"px\";\n      }\n    }\n  }\n\n  open(i) {\n    const item = this.accordionItems[i];\n    const toggle = this.toggles[i];\n    const content = this.contents[i]; // If applicable, hide all the other items first\n\n    if (this.settings.one_visible) {\n      for (let a = 0; a < this.toggles.length; a++) {\n        if (i !== a) this.close(a);\n      }\n    } // Update class\n\n\n    item.classList.remove(\"is-closing\"); // Get height of toggle\n\n    const toggle_height = toggle.clientHeight; // Momentarily show the contents just to get the height\n\n    item.setAttribute(\"open\", true);\n    toggle.setAttribute(\"aria-expanded\", true);\n    const content_height = content.clientHeight;\n    item.removeAttribute(\"open\"); // Set the correct height and let CSS transition it\n\n    item.style.height = toggle_height + content_height + \"px\"; // Finally set the open attr\n\n    item.setAttribute(\"open\", true);\n  }\n\n  close(i) {\n    const item = this.accordionItems[i];\n    const toggle = this.toggles[i]; // Get height of toggle\n\n    const toggle_height = toggle.clientHeight; // Set aria attribute to false\n\n    toggle.setAttribute(\"aria-expanded\", false); // Set the height so only the toggle is visible\n\n    item.style.height = toggle_height + \"px\";\n    item.removeAttribute(\"open\");\n  }\n\n}\n\n/* harmony default export */ __webpack_exports__[\"default\"] = (() => {\n  const els = document.getElementsByClassName(\"bmcb-accordion\");\n\n  for (let i = 0; i < els.length; i++) {\n    const accordion = new Accordion(els[i]);\n  }\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9zcmMvanMvY29tcG9uZW50cy9hY2NvcmRpb24uanMuanMiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9zcmMvanMvY29tcG9uZW50cy9hY2NvcmRpb24uanM/NzhmZCJdLCJzb3VyY2VzQ29udGVudCI6WyJpbXBvcnQgZGVib3VuY2UgZnJvbSAnLi4vdXRpbC9kZWJvdW5jZSc7XG5cbmNsYXNzIEFjY29yZGlvbiB7XG4gIGNvbnN0cnVjdG9yKGVsLCBzZXR0aW5ncykge1xuICAgIHRoaXMuZ3JvdXAgPSBlbDtcbiAgICB0aGlzLmFjY29yZGlvbkl0ZW1zID0gdGhpcy5ncm91cC5nZXRFbGVtZW50c0J5Q2xhc3NOYW1lKFwiYWNjb3JkaW9uXCIpO1xuICAgIHRoaXMudG9nZ2xlcyA9IHRoaXMuZ3JvdXAuZ2V0RWxlbWVudHNCeUNsYXNzTmFtZShcImFjY29yZGlvbi10aXRsZVwiKTtcbiAgICB0aGlzLmNvbnRlbnRzID0gdGhpcy5ncm91cC5nZXRFbGVtZW50c0J5Q2xhc3NOYW1lKFwiYWNjb3JkaW9uLWJvZHlcIik7XG5cbiAgICBpZiAoIXRoaXMuZ3JvdXAgfHwgIXRoaXMuYWNjb3JkaW9uSXRlbXMgfHwgIXRoaXMudG9nZ2xlcyB8fCAhdGhpcy5jb250ZW50cykge1xuICAgICAgcmV0dXJuO1xuICAgIH0gLy8gU2V0IGRlZmF1bHQgc2V0dGluZ3MgaWYgbmVjZXNzYXJ5XG5cblxuICAgIHRoaXMuc2V0dGluZ3MgPSB7XG4gICAgICBzcGVlZDogMzAwLFxuICAgICAgb25lX3Zpc2libGU6IGZhbHNlLFxuICAgICAgLi4uc2V0dGluZ3NcbiAgICB9OyAvLyBTZXR1cCBpbml0YWwgcG9zaXRpb25zXG5cbiAgICB0aGlzLnNpemVBY2NvcmRpb25zKCk7XG4gICAgd2luZG93LmFkZEV2ZW50TGlzdGVuZXIoJ3Jlc2l6ZScsIGRlYm91bmNlKCgpID0+IHRoaXMuc2l6ZUFjY29yZGlvbnMoKSwgNTApKTsgLy8gU2V0dXAgY2xpY2sgaGFuZGxlclxuXG4gICAgdGhpcy5ncm91cC5hZGRFdmVudExpc3RlbmVyKFwiY2xpY2tcIiwgZSA9PiB7XG4gICAgICBpZiAoZS50YXJnZXQuY2xhc3NMaXN0LmNvbnRhaW5zKFwiYWNjb3JkaW9uLXRpdGxlXCIpKSB7XG4gICAgICAgIGUucHJldmVudERlZmF1bHQoKTtcbiAgICAgICAgbGV0IG51bSA9IDA7XG5cbiAgICAgICAgZm9yIChsZXQgaSA9IDA7IGkgPCB0aGlzLnRvZ2dsZXMubGVuZ3RoOyBpKyspIHtcbiAgICAgICAgICBpZiAodGhpcy50b2dnbGVzW2ldID09PSBlLnRhcmdldCkge1xuICAgICAgICAgICAgbnVtID0gaTtcbiAgICAgICAgICAgIGJyZWFrO1xuICAgICAgICAgIH1cbiAgICAgICAgfVxuXG4gICAgICAgIGlmICghZS50YXJnZXQucGFyZW50Tm9kZS5oYXNBdHRyaWJ1dGUoXCJvcGVuXCIpKSB7XG4gICAgICAgICAgdGhpcy5vcGVuKG51bSk7XG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgdGhpcy5jbG9zZShudW0pO1xuICAgICAgICB9XG4gICAgICB9XG4gICAgfSk7XG4gIH1cblxuICBzaXplQWNjb3JkaW9ucygpIHtcbiAgICBpZiAoIXRoaXMuYWNjb3JkaW9uSXRlbXMpIHtcbiAgICAgIHJldHVybjtcbiAgICB9XG5cbiAgICBmb3IgKGxldCBpID0gMDsgaSA8IHRoaXMuYWNjb3JkaW9uSXRlbXMubGVuZ3RoOyBpKyspIHtcbiAgICAgIGNvbnN0IGl0ZW0gPSB0aGlzLmFjY29yZGlvbkl0ZW1zW2ldO1xuICAgICAgY29uc3QgdG9nZ2xlID0gdGhpcy50b2dnbGVzW2ldO1xuICAgICAgY29uc3QgY29udGVudCA9IHRoaXMuY29udGVudHNbaV07IC8vIFNldCB0cmFuc2l0aW9uLWR1cmF0aW9uIHRvIG1hdGNoIEpTIHNldHRpbmdcblxuICAgICAgaXRlbS5zdHlsZS50cmFuc2l0aW9uRHVyYXRpb24gPSB0aGlzLnNldHRpbmdzLnNwZWVkICsgXCJtc1wiOyAvLyBTZXQgaW5pdGlhbCBoZWlnaHQgdG8gdHJhbnNpdGlvbiBmcm9tXG5cbiAgICAgIGlmICghaXRlbS5oYXNBdHRyaWJ1dGUoXCJvcGVuXCIpKSB7XG4gICAgICAgIGl0ZW0uc3R5bGUuaGVpZ2h0ID0gdG9nZ2xlLmNsaWVudEhlaWdodCArIFwicHhcIjtcbiAgICAgIH0gZWxzZSB7XG4gICAgICAgIGl0ZW0uc3R5bGUuaGVpZ2h0ID0gdG9nZ2xlLmNsaWVudEhlaWdodCArIGNvbnRlbnQuY2xpZW50SGVpZ2h0ICsgXCJweFwiO1xuICAgICAgfVxuICAgIH1cbiAgfVxuXG4gIG9wZW4oaSkge1xuICAgIGNvbnN0IGl0ZW0gPSB0aGlzLmFjY29yZGlvbkl0ZW1zW2ldO1xuICAgIGNvbnN0IHRvZ2dsZSA9IHRoaXMudG9nZ2xlc1tpXTtcbiAgICBjb25zdCBjb250ZW50ID0gdGhpcy5jb250ZW50c1tpXTsgLy8gSWYgYXBwbGljYWJsZSwgaGlkZSBhbGwgdGhlIG90aGVyIGl0ZW1zIGZpcnN0XG5cbiAgICBpZiAodGhpcy5zZXR0aW5ncy5vbmVfdmlzaWJsZSkge1xuICAgICAgZm9yIChsZXQgYSA9IDA7IGEgPCB0aGlzLnRvZ2dsZXMubGVuZ3RoOyBhKyspIHtcbiAgICAgICAgaWYgKGkgIT09IGEpIHRoaXMuY2xvc2UoYSk7XG4gICAgICB9XG4gICAgfSAvLyBVcGRhdGUgY2xhc3NcblxuXG4gICAgaXRlbS5jbGFzc0xpc3QucmVtb3ZlKFwiaXMtY2xvc2luZ1wiKTsgLy8gR2V0IGhlaWdodCBvZiB0b2dnbGVcblxuICAgIGNvbnN0IHRvZ2dsZV9oZWlnaHQgPSB0b2dnbGUuY2xpZW50SGVpZ2h0OyAvLyBNb21lbnRhcmlseSBzaG93IHRoZSBjb250ZW50cyBqdXN0IHRvIGdldCB0aGUgaGVpZ2h0XG5cbiAgICBpdGVtLnNldEF0dHJpYnV0ZShcIm9wZW5cIiwgdHJ1ZSk7XG4gICAgdG9nZ2xlLnNldEF0dHJpYnV0ZShcImFyaWEtZXhwYW5kZWRcIiwgdHJ1ZSk7XG4gICAgY29uc3QgY29udGVudF9oZWlnaHQgPSBjb250ZW50LmNsaWVudEhlaWdodDtcbiAgICBpdGVtLnJlbW92ZUF0dHJpYnV0ZShcIm9wZW5cIik7IC8vIFNldCB0aGUgY29ycmVjdCBoZWlnaHQgYW5kIGxldCBDU1MgdHJhbnNpdGlvbiBpdFxuXG4gICAgaXRlbS5zdHlsZS5oZWlnaHQgPSB0b2dnbGVfaGVpZ2h0ICsgY29udGVudF9oZWlnaHQgKyBcInB4XCI7IC8vIEZpbmFsbHkgc2V0IHRoZSBvcGVuIGF0dHJcblxuICAgIGl0ZW0uc2V0QXR0cmlidXRlKFwib3BlblwiLCB0cnVlKTtcbiAgfVxuXG4gIGNsb3NlKGkpIHtcbiAgICBjb25zdCBpdGVtID0gdGhpcy5hY2NvcmRpb25JdGVtc1tpXTtcbiAgICBjb25zdCB0b2dnbGUgPSB0aGlzLnRvZ2dsZXNbaV07IC8vIEdldCBoZWlnaHQgb2YgdG9nZ2xlXG5cbiAgICBjb25zdCB0b2dnbGVfaGVpZ2h0ID0gdG9nZ2xlLmNsaWVudEhlaWdodDsgLy8gU2V0IGFyaWEgYXR0cmlidXRlIHRvIGZhbHNlXG5cbiAgICB0b2dnbGUuc2V0QXR0cmlidXRlKFwiYXJpYS1leHBhbmRlZFwiLCBmYWxzZSk7IC8vIFNldCB0aGUgaGVpZ2h0IHNvIG9ubHkgdGhlIHRvZ2dsZSBpcyB2aXNpYmxlXG5cbiAgICBpdGVtLnN0eWxlLmhlaWdodCA9IHRvZ2dsZV9oZWlnaHQgKyBcInB4XCI7XG4gICAgaXRlbS5yZW1vdmVBdHRyaWJ1dGUoXCJvcGVuXCIpO1xuICB9XG5cbn1cblxuZXhwb3J0IGRlZmF1bHQgKCgpID0+IHtcbiAgY29uc3QgZWxzID0gZG9jdW1lbnQuZ2V0RWxlbWVudHNCeUNsYXNzTmFtZShcImJtY2ItYWNjb3JkaW9uXCIpO1xuXG4gIGZvciAobGV0IGkgPSAwOyBpIDwgZWxzLmxlbmd0aDsgaSsrKSB7XG4gICAgY29uc3QgYWNjb3JkaW9uID0gbmV3IEFjY29yZGlvbihlbHNbaV0pO1xuICB9XG59KTsiXSwibWFwcGluZ3MiOiJBQUFBO0FBQUE7QUFBQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EiLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./src/js/components/accordion.js\n");

/***/ }),

/***/ "./src/js/main.js":
/*!************************!*\
  !*** ./src/js/main.js ***!
  \************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _components_accordion__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./components/accordion */ \"./src/js/components/accordion.js\");\n\nObject(_components_accordion__WEBPACK_IMPORTED_MODULE_0__[\"default\"])();//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9zcmMvanMvbWFpbi5qcy5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy8uL3NyYy9qcy9tYWluLmpzPzA5NGUiXSwic291cmNlc0NvbnRlbnQiOlsiaW1wb3J0IGFjY29yZGlvbnMgZnJvbSAnLi9jb21wb25lbnRzL2FjY29yZGlvbic7XG5hY2NvcmRpb25zKCk7Il0sIm1hcHBpbmdzIjoiQUFBQTtBQUFBO0FBQUE7QUFDQSIsInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./src/js/main.js\n");

/***/ }),

/***/ "./src/js/util/debounce.js":
/*!*********************************!*\
  !*** ./src/js/util/debounce.js ***!
  \*********************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"default\", function() { return debounce; });\n/* Debounce prevents burst fires by triggering once, then ignoring until the timeout\n    * @param func -- The function you're debouncing\n    * @param wait -- Delay before firing again after the hit\n    * @param immediate -- fire instantly at the start\n    * @param trailing -- fire at the end no matter what\n    * @returns {Function}\n    */\nfunction debounce(func, wait, immediate, trailing) {\n  var timeout;\n  return function () {\n    var context = this,\n        args = arguments;\n\n    var later = function () {\n      timeout = null;\n\n      if (!immediate) {\n        func.apply(context, args);\n      } // Added this so it will always fire at the end as well\n\n\n      if (trailing) {\n        func.apply(context, args);\n        console.log('fired later');\n      }\n    };\n\n    var callNow = immediate && !timeout;\n    clearTimeout(timeout);\n    timeout = setTimeout(later, wait);\n    if (callNow) func.apply(context, args);\n  };\n}//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9zcmMvanMvdXRpbC9kZWJvdW5jZS5qcy5qcyIsInNvdXJjZXMiOlsid2VicGFjazovLy8uL3NyYy9qcy91dGlsL2RlYm91bmNlLmpzPzRjZTYiXSwic291cmNlc0NvbnRlbnQiOlsiLyogRGVib3VuY2UgcHJldmVudHMgYnVyc3QgZmlyZXMgYnkgdHJpZ2dlcmluZyBvbmNlLCB0aGVuIGlnbm9yaW5nIHVudGlsIHRoZSB0aW1lb3V0XG4gICAgKiBAcGFyYW0gZnVuYyAtLSBUaGUgZnVuY3Rpb24geW91J3JlIGRlYm91bmNpbmdcbiAgICAqIEBwYXJhbSB3YWl0IC0tIERlbGF5IGJlZm9yZSBmaXJpbmcgYWdhaW4gYWZ0ZXIgdGhlIGhpdFxuICAgICogQHBhcmFtIGltbWVkaWF0ZSAtLSBmaXJlIGluc3RhbnRseSBhdCB0aGUgc3RhcnRcbiAgICAqIEBwYXJhbSB0cmFpbGluZyAtLSBmaXJlIGF0IHRoZSBlbmQgbm8gbWF0dGVyIHdoYXRcbiAgICAqIEByZXR1cm5zIHtGdW5jdGlvbn1cbiAgICAqL1xuZXhwb3J0IGRlZmF1bHQgZnVuY3Rpb24gZGVib3VuY2UoZnVuYywgd2FpdCwgaW1tZWRpYXRlLCB0cmFpbGluZykge1xuICB2YXIgdGltZW91dDtcbiAgcmV0dXJuIGZ1bmN0aW9uICgpIHtcbiAgICB2YXIgY29udGV4dCA9IHRoaXMsXG4gICAgICAgIGFyZ3MgPSBhcmd1bWVudHM7XG5cbiAgICB2YXIgbGF0ZXIgPSBmdW5jdGlvbiAoKSB7XG4gICAgICB0aW1lb3V0ID0gbnVsbDtcblxuICAgICAgaWYgKCFpbW1lZGlhdGUpIHtcbiAgICAgICAgZnVuYy5hcHBseShjb250ZXh0LCBhcmdzKTtcbiAgICAgIH0gLy8gQWRkZWQgdGhpcyBzbyBpdCB3aWxsIGFsd2F5cyBmaXJlIGF0IHRoZSBlbmQgYXMgd2VsbFxuXG5cbiAgICAgIGlmICh0cmFpbGluZykge1xuICAgICAgICBmdW5jLmFwcGx5KGNvbnRleHQsIGFyZ3MpO1xuICAgICAgICBjb25zb2xlLmxvZygnZmlyZWQgbGF0ZXInKTtcbiAgICAgIH1cbiAgICB9O1xuXG4gICAgdmFyIGNhbGxOb3cgPSBpbW1lZGlhdGUgJiYgIXRpbWVvdXQ7XG4gICAgY2xlYXJUaW1lb3V0KHRpbWVvdXQpO1xuICAgIHRpbWVvdXQgPSBzZXRUaW1lb3V0KGxhdGVyLCB3YWl0KTtcbiAgICBpZiAoY2FsbE5vdykgZnVuYy5hcHBseShjb250ZXh0LCBhcmdzKTtcbiAgfTtcbn0iXSwibWFwcGluZ3MiOiJBQUFBO0FBQUE7QUFBQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EiLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./src/js/util/debounce.js\n");

/***/ }),

/***/ "./src/sass/style.scss":
/*!*****************************!*\
  !*** ./src/sass/style.scss ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

eval("// extracted by mini-css-extract-plugin//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiLi9zcmMvc2Fzcy9zdHlsZS5zY3NzLmpzIiwic291cmNlcyI6WyJ3ZWJwYWNrOi8vLy4vc3JjL3Nhc3Mvc3R5bGUuc2Nzcz9hMjgwIl0sInNvdXJjZXNDb250ZW50IjpbIi8vIGV4dHJhY3RlZCBieSBtaW5pLWNzcy1leHRyYWN0LXBsdWdpbiJdLCJtYXBwaW5ncyI6IkFBQUEiLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./src/sass/style.scss\n");

/***/ }),

/***/ 0:
/*!****************************************************!*\
  !*** multi ./src/js/main.js ./src/sass/style.scss ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! ./src/js/main.js */"./src/js/main.js");
module.exports = __webpack_require__(/*! ./src/sass/style.scss */"./src/sass/style.scss");


/***/ })

/******/ });