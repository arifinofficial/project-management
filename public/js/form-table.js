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
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./node_modules/webpack/buildin/global.js":
/*!***********************************!*\
  !*** (webpack)/buildin/global.js ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports) {

var g;

// This works in non-strict mode
g = (function() {
	return this;
})();

try {
	// This works if eval is allowed (see CSP)
	g = g || new Function("return this")();
} catch (e) {
	// This works if the window reference is available
	if (typeof window === "object") g = window;
}

// g can still be undefined, but nothing to do about it...
// We return undefined, instead of nothing here, so it's
// easier to handle this case. if(!global) { ...}

module.exports = g;


/***/ }),

/***/ "./resources/js/form-table.js":
/*!************************************!*\
  !*** ./resources/js/form-table.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(global) {$(document).ready(function () {
  $('.container-fluid').on('click', '.editAction', function () {
    vm.$data.action.editUrl = $(this).data('action');
  });
  $('.container-fluid').on('click', '.deleteAction', function () {
    vm.$data.action.deleteUrl = $(this).data('action');
  });
});
var app = new Vue({
  el: '#app',
  data: {
    formAction: '',
    action: {
      storeUrl: '',
      editUrl: '',
      deleteUrl: ''
    },
    fetch: false,
    model: {}
  },
  mounted: function mounted() {
    this.action.storeUrl = this.$refs.store_update ? this.$refs.store_update.value : '';
  },
  watch: {
    'action.editUrl': function actionEditUrl() {
      this.editMethod();
    },
    'action.deleteUrl': function actionDeleteUrl() {
      this.deleteMethod();
    }
  },
  computed: {
    formUrl: function formUrl() {
      return this.fetch == true ? this.action.storeUrl + '/' + this.model.id : this.action.storeUrl;
    },
    submitText: function submitText() {
      return this.fetch == true ? 'Ubah' : 'Tambah';
    }
  },
  methods: {
    submitForm: function submitForm() {
      var _this = this;

      this.$validator.validate().then(function (valid) {
        if (valid) {
          if (_this.fetch == true) {
            axios.patch(_this.formUrl, _this.model).then(function (response) {
              _this.model = {};
              _this.fetch = false;
              $('#dataTable').DataTable().ajax.reload();
              toastr.success(response.data.message);
            })["catch"](function (error) {
              var errors = error.response.data.errors;
              toastr.error(Object.values(errors)[0]);
            });
          } else {
            axios.post(_this.formUrl, _this.model).then(function (response) {
              _this.model = {};
              $('#dataTable').DataTable().ajax.reload();
              toastr.success(response.data.message);
            })["catch"](function (error) {
              var errors = error.response.data.errors;
              toastr.error(Object.values(errors)[0]);
            });
          }
        }
      });
    },
    editMethod: function editMethod() {
      var _this2 = this;

      axios.get(this.action.editUrl).then(function (response) {
        _this2.model = response.data;
        _this2.fetch = true;
      });
    },
    deleteMethod: function deleteMethod() {
      axios["delete"](this.action.deleteUrl).then(function (response) {
        $('#dataTable').DataTable().ajax.reload();
        toastr.success(response.data.message);
      });
    }
  }
});
global.vm = app;
/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! ./../../node_modules/webpack/buildin/global.js */ "./node_modules/webpack/buildin/global.js")))

/***/ }),

/***/ 1:
/*!******************************************!*\
  !*** multi ./resources/js/form-table.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Volumes/Developments/Website/project-management/resources/js/form-table.js */"./resources/js/form-table.js");


/***/ })

/******/ });