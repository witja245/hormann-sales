this.BX = this.BX || {};
(function (exports,ui_vue) {
	'use strict';

	var commonjsGlobal = typeof globalThis !== 'undefined' ? globalThis : typeof window !== 'undefined' ? window : typeof global !== 'undefined' ? global : typeof self !== 'undefined' ? self : {};
	function commonjsRequire() {
	  throw new Error('Dynamic requires are not currently supported by rollup-plugin-commonjs');
	}
	function createCommonjsModule(fn, module) {
	  return module = {
	    exports: {}
	  }, fn(module, module.exports), module.exports;
	}

	var es6Promise = createCommonjsModule(function (module, exports) {
	/*!
	 * @overview es6-promise - a tiny implementation of Promises/A+.
	 * @copyright Copyright (c) 2014 Yehuda Katz, Tom Dale, Stefan Penner and contributors (Conversion to ES6 API by Jake Archibald)
	 * @license   Licensed under MIT license
	 *            See https://raw.githubusercontent.com/stefanpenner/es6-promise/master/LICENSE
	 * @version   4.0.5
	 */
	(function (global, factory) {
	  (babelHelpers.typeof(exports)) === 'object' && 'object' !== 'undefined' ? module.exports = factory() : global.ES6Promise = factory();
	})(commonjsGlobal, function () {

	  function objectOrFunction(x) {
	    return typeof x === 'function' || babelHelpers.typeof(x) === 'object' && x !== null;
	  }

	  function isFunction(x) {
	    return typeof x === 'function';
	  }

	  var _isArray = undefined;

	  if (!Array.isArray) {
	    _isArray = function _isArray(x) {
	      return Object.prototype.toString.call(x) === '[object Array]';
	    };
	  } else {
	    _isArray = Array.isArray;
	  }

	  var isArray = _isArray;
	  var len = 0;
	  var vertxNext = undefined;
	  var customSchedulerFn = undefined;

	  var asap = function asap(callback, arg) {
	    queue[len] = callback;
	    queue[len + 1] = arg;
	    len += 2;

	    if (len === 2) {
	      // If len is 2, that means that we need to schedule an async flush.
	      // If additional callbacks are queued before the queue is flushed, they
	      // will be processed by this flush that we are scheduling.
	      if (customSchedulerFn) {
	        customSchedulerFn(flush);
	      } else {
	        scheduleFlush();
	      }
	    }
	  };

	  function setScheduler(scheduleFn) {
	    customSchedulerFn = scheduleFn;
	  }

	  function setAsap(asapFn) {
	    asap = asapFn;
	  }

	  var browserWindow = typeof window !== 'undefined' ? window : undefined;
	  var browserGlobal = browserWindow || {};
	  var BrowserMutationObserver = browserGlobal.MutationObserver || browserGlobal.WebKitMutationObserver;
	  var isNode = typeof self === 'undefined' && typeof process !== 'undefined' && {}.toString.call(process) === '[object process]'; // test for web worker but not in IE10

	  var isWorker = typeof Uint8ClampedArray !== 'undefined' && typeof importScripts !== 'undefined' && typeof MessageChannel !== 'undefined'; // node

	  function useNextTick() {
	    // node version 0.10.x displays a deprecation warning when nextTick is used recursively
	    // see https://github.com/cujojs/when/issues/410 for details
	    return function () {
	      return process.nextTick(flush);
	    };
	  } // vertx


	  function useVertxTimer() {
	    if (typeof vertxNext !== 'undefined') {
	      return function () {
	        vertxNext(flush);
	      };
	    }

	    return useSetTimeout();
	  }

	  function useMutationObserver() {
	    var iterations = 0;
	    var observer = new BrowserMutationObserver(flush);
	    var node = document.createTextNode('');
	    observer.observe(node, {
	      characterData: true
	    });
	    return function () {
	      node.data = iterations = ++iterations % 2;
	    };
	  } // web worker


	  function useMessageChannel() {
	    var channel = new MessageChannel();
	    channel.port1.onmessage = flush;
	    return function () {
	      return channel.port2.postMessage(0);
	    };
	  }

	  function useSetTimeout() {
	    // Store setTimeout reference so es6-promise will be unaffected by
	    // other code modifying setTimeout (like sinon.useFakeTimers())
	    var globalSetTimeout = setTimeout;
	    return function () {
	      return globalSetTimeout(flush, 1);
	    };
	  }

	  var queue = new Array(1000);

	  function flush() {
	    for (var i = 0; i < len; i += 2) {
	      var callback = queue[i];
	      var arg = queue[i + 1];
	      callback(arg);
	      queue[i] = undefined;
	      queue[i + 1] = undefined;
	    }

	    len = 0;
	  }

	  function attemptVertx() {
	    try {
	      var r = commonjsRequire;
	      var vertx = r('vertx');
	      vertxNext = vertx.runOnLoop || vertx.runOnContext;
	      return useVertxTimer();
	    } catch (e) {
	      return useSetTimeout();
	    }
	  }

	  var scheduleFlush = undefined; // Decide what async method to use to triggering processing of queued callbacks:

	  if (isNode) {
	    scheduleFlush = useNextTick();
	  } else if (BrowserMutationObserver) {
	    scheduleFlush = useMutationObserver();
	  } else if (isWorker) {
	    scheduleFlush = useMessageChannel();
	  } else if (browserWindow === undefined && typeof commonjsRequire === 'function') {
	    scheduleFlush = attemptVertx();
	  } else {
	    scheduleFlush = useSetTimeout();
	  }

	  function then(onFulfillment, onRejection) {
	    var _arguments = arguments;
	    var parent = this;
	    var child = new this.constructor(noop);

	    if (child[PROMISE_ID] === undefined) {
	      makePromise(child);
	    }

	    var _state = parent._state;

	    if (_state) {
	      (function () {
	        var callback = _arguments[_state - 1];
	        asap(function () {
	          return invokeCallback(_state, child, callback, parent._result);
	        });
	      })();
	    } else {
	      subscribe(parent, child, onFulfillment, onRejection);
	    }

	    return child;
	  }
	  /**
	    `Promise.resolve` returns a promise that will become resolved with the
	    passed `value`. It is shorthand for the following:
	  
	    ```javascript
	    let promise = new Promise(function(resolve, reject){
	      resolve(1);
	    });
	  
	    promise.then(function(value){
	      // value === 1
	    });
	    ```
	  
	    Instead of writing the above, your code now simply becomes the following:
	  
	    ```javascript
	    let promise = Promise.resolve(1);
	  
	    promise.then(function(value){
	      // value === 1
	    });
	    ```
	  
	    @method resolve
	    @static
	    @param {Any} value value that the returned promise will be resolved with
	    Useful for tooling.
	    @return {Promise} a promise that will become fulfilled with the given
	    `value`
	  */


	  function resolve(object) {
	    /*jshint validthis:true */
	    var Constructor = this;

	    if (object && babelHelpers.typeof(object) === 'object' && object.constructor === Constructor) {
	      return object;
	    }

	    var promise = new Constructor(noop);

	    _resolve(promise, object);

	    return promise;
	  }

	  var PROMISE_ID = Math.random().toString(36).substring(16);

	  function noop() {}

	  var PENDING = void 0;
	  var FULFILLED = 1;
	  var REJECTED = 2;
	  var GET_THEN_ERROR = new ErrorObject();

	  function selfFulfillment() {
	    return new TypeError("You cannot resolve a promise with itself");
	  }

	  function cannotReturnOwn() {
	    return new TypeError('A promises callback cannot return that same promise.');
	  }

	  function getThen(promise) {
	    try {
	      return promise.then;
	    } catch (error) {
	      GET_THEN_ERROR.error = error;
	      return GET_THEN_ERROR;
	    }
	  }

	  function tryThen(then, value, fulfillmentHandler, rejectionHandler) {
	    try {
	      then.call(value, fulfillmentHandler, rejectionHandler);
	    } catch (e) {
	      return e;
	    }
	  }

	  function handleForeignThenable(promise, thenable, then) {
	    asap(function (promise) {
	      var sealed = false;
	      var error = tryThen(then, thenable, function (value) {
	        if (sealed) {
	          return;
	        }

	        sealed = true;

	        if (thenable !== value) {
	          _resolve(promise, value);
	        } else {
	          fulfill(promise, value);
	        }
	      }, function (reason) {
	        if (sealed) {
	          return;
	        }

	        sealed = true;

	        _reject(promise, reason);
	      }, 'Settle: ' + (promise._label || ' unknown promise'));

	      if (!sealed && error) {
	        sealed = true;

	        _reject(promise, error);
	      }
	    }, promise);
	  }

	  function handleOwnThenable(promise, thenable) {
	    if (thenable._state === FULFILLED) {
	      fulfill(promise, thenable._result);
	    } else if (thenable._state === REJECTED) {
	      _reject(promise, thenable._result);
	    } else {
	      subscribe(thenable, undefined, function (value) {
	        return _resolve(promise, value);
	      }, function (reason) {
	        return _reject(promise, reason);
	      });
	    }
	  }

	  function handleMaybeThenable(promise, maybeThenable, then$$) {
	    if (maybeThenable.constructor === promise.constructor && then$$ === then && maybeThenable.constructor.resolve === resolve) {
	      handleOwnThenable(promise, maybeThenable);
	    } else {
	      if (then$$ === GET_THEN_ERROR) {
	        _reject(promise, GET_THEN_ERROR.error);
	      } else if (then$$ === undefined) {
	        fulfill(promise, maybeThenable);
	      } else if (isFunction(then$$)) {
	        handleForeignThenable(promise, maybeThenable, then$$);
	      } else {
	        fulfill(promise, maybeThenable);
	      }
	    }
	  }

	  function _resolve(promise, value) {
	    if (promise === value) {
	      _reject(promise, selfFulfillment());
	    } else if (objectOrFunction(value)) {
	      handleMaybeThenable(promise, value, getThen(value));
	    } else {
	      fulfill(promise, value);
	    }
	  }

	  function publishRejection(promise) {
	    if (promise._onerror) {
	      promise._onerror(promise._result);
	    }

	    publish(promise);
	  }

	  function fulfill(promise, value) {
	    if (promise._state !== PENDING) {
	      return;
	    }

	    promise._result = value;
	    promise._state = FULFILLED;

	    if (promise._subscribers.length !== 0) {
	      asap(publish, promise);
	    }
	  }

	  function _reject(promise, reason) {
	    if (promise._state !== PENDING) {
	      return;
	    }

	    promise._state = REJECTED;
	    promise._result = reason;
	    asap(publishRejection, promise);
	  }

	  function subscribe(parent, child, onFulfillment, onRejection) {
	    var _subscribers = parent._subscribers;
	    var length = _subscribers.length;
	    parent._onerror = null;
	    _subscribers[length] = child;
	    _subscribers[length + FULFILLED] = onFulfillment;
	    _subscribers[length + REJECTED] = onRejection;

	    if (length === 0 && parent._state) {
	      asap(publish, parent);
	    }
	  }

	  function publish(promise) {
	    var subscribers = promise._subscribers;
	    var settled = promise._state;

	    if (subscribers.length === 0) {
	      return;
	    }

	    var child = undefined,
	        callback = undefined,
	        detail = promise._result;

	    for (var i = 0; i < subscribers.length; i += 3) {
	      child = subscribers[i];
	      callback = subscribers[i + settled];

	      if (child) {
	        invokeCallback(settled, child, callback, detail);
	      } else {
	        callback(detail);
	      }
	    }

	    promise._subscribers.length = 0;
	  }

	  function ErrorObject() {
	    this.error = null;
	  }

	  var TRY_CATCH_ERROR = new ErrorObject();

	  function tryCatch(callback, detail) {
	    try {
	      return callback(detail);
	    } catch (e) {
	      TRY_CATCH_ERROR.error = e;
	      return TRY_CATCH_ERROR;
	    }
	  }

	  function invokeCallback(settled, promise, callback, detail) {
	    var hasCallback = isFunction(callback),
	        value = undefined,
	        error = undefined,
	        succeeded = undefined,
	        failed = undefined;

	    if (hasCallback) {
	      value = tryCatch(callback, detail);

	      if (value === TRY_CATCH_ERROR) {
	        failed = true;
	        error = value.error;
	        value = null;
	      } else {
	        succeeded = true;
	      }

	      if (promise === value) {
	        _reject(promise, cannotReturnOwn());

	        return;
	      }
	    } else {
	      value = detail;
	      succeeded = true;
	    }

	    if (promise._state !== PENDING) ; else if (hasCallback && succeeded) {
	      _resolve(promise, value);
	    } else if (failed) {
	      _reject(promise, error);
	    } else if (settled === FULFILLED) {
	      fulfill(promise, value);
	    } else if (settled === REJECTED) {
	      _reject(promise, value);
	    }
	  }

	  function initializePromise(promise, resolver) {
	    try {
	      resolver(function resolvePromise(value) {
	        _resolve(promise, value);
	      }, function rejectPromise(reason) {
	        _reject(promise, reason);
	      });
	    } catch (e) {
	      _reject(promise, e);
	    }
	  }

	  var id = 0;

	  function nextId() {
	    return id++;
	  }

	  function makePromise(promise) {
	    promise[PROMISE_ID] = id++;
	    promise._state = undefined;
	    promise._result = undefined;
	    promise._subscribers = [];
	  }

	  function Enumerator(Constructor, input) {
	    this._instanceConstructor = Constructor;
	    this.promise = new Constructor(noop);

	    if (!this.promise[PROMISE_ID]) {
	      makePromise(this.promise);
	    }

	    if (isArray(input)) {
	      this._input = input;
	      this.length = input.length;
	      this._remaining = input.length;
	      this._result = new Array(this.length);

	      if (this.length === 0) {
	        fulfill(this.promise, this._result);
	      } else {
	        this.length = this.length || 0;

	        this._enumerate();

	        if (this._remaining === 0) {
	          fulfill(this.promise, this._result);
	        }
	      }
	    } else {
	      _reject(this.promise, validationError());
	    }
	  }

	  function validationError() {
	    return new Error('Array Methods must be provided an Array');
	  }

	  Enumerator.prototype._enumerate = function () {
	    var length = this.length;
	    var _input = this._input;

	    for (var i = 0; this._state === PENDING && i < length; i++) {
	      this._eachEntry(_input[i], i);
	    }
	  };

	  Enumerator.prototype._eachEntry = function (entry, i) {
	    var c = this._instanceConstructor;
	    var resolve$$ = c.resolve;

	    if (resolve$$ === resolve) {
	      var _then = getThen(entry);

	      if (_then === then && entry._state !== PENDING) {
	        this._settledAt(entry._state, i, entry._result);
	      } else if (typeof _then !== 'function') {
	        this._remaining--;
	        this._result[i] = entry;
	      } else if (c === Promise) {
	        var promise = new c(noop);
	        handleMaybeThenable(promise, entry, _then);

	        this._willSettleAt(promise, i);
	      } else {
	        this._willSettleAt(new c(function (resolve$$) {
	          return resolve$$(entry);
	        }), i);
	      }
	    } else {
	      this._willSettleAt(resolve$$(entry), i);
	    }
	  };

	  Enumerator.prototype._settledAt = function (state, i, value) {
	    var promise = this.promise;

	    if (promise._state === PENDING) {
	      this._remaining--;

	      if (state === REJECTED) {
	        _reject(promise, value);
	      } else {
	        this._result[i] = value;
	      }
	    }

	    if (this._remaining === 0) {
	      fulfill(promise, this._result);
	    }
	  };

	  Enumerator.prototype._willSettleAt = function (promise, i) {
	    var enumerator = this;
	    subscribe(promise, undefined, function (value) {
	      return enumerator._settledAt(FULFILLED, i, value);
	    }, function (reason) {
	      return enumerator._settledAt(REJECTED, i, reason);
	    });
	  };
	  /**
	    `Promise.all` accepts an array of promises, and returns a new promise which
	    is fulfilled with an array of fulfillment values for the passed promises, or
	    rejected with the reason of the first passed promise to be rejected. It casts all
	    elements of the passed iterable to promises as it runs this algorithm.
	  
	    Example:
	  
	    ```javascript
	    let promise1 = resolve(1);
	    let promise2 = resolve(2);
	    let promise3 = resolve(3);
	    let promises = [ promise1, promise2, promise3 ];
	  
	    Promise.all(promises).then(function(array){
	      // The array here would be [ 1, 2, 3 ];
	    });
	    ```
	  
	    If any of the `promises` given to `all` are rejected, the first promise
	    that is rejected will be given as an argument to the returned promises's
	    rejection handler. For example:
	  
	    Example:
	  
	    ```javascript
	    let promise1 = resolve(1);
	    let promise2 = reject(new Error("2"));
	    let promise3 = reject(new Error("3"));
	    let promises = [ promise1, promise2, promise3 ];
	  
	    Promise.all(promises).then(function(array){
	      // Code here never runs because there are rejected promises!
	    }, function(error) {
	      // error.message === "2"
	    });
	    ```
	  
	    @method all
	    @static
	    @param {Array} entries array of promises
	    @param {String} label optional string for labeling the promise.
	    Useful for tooling.
	    @return {Promise} promise that is fulfilled when all `promises` have been
	    fulfilled, or rejected if any of them become rejected.
	    @static
	  */


	  function all(entries) {
	    return new Enumerator(this, entries).promise;
	  }
	  /**
	    `Promise.race` returns a new promise which is settled in the same way as the
	    first passed promise to settle.
	  
	    Example:
	  
	    ```javascript
	    let promise1 = new Promise(function(resolve, reject){
	      setTimeout(function(){
	        resolve('promise 1');
	      }, 200);
	    });
	  
	    let promise2 = new Promise(function(resolve, reject){
	      setTimeout(function(){
	        resolve('promise 2');
	      }, 100);
	    });
	  
	    Promise.race([promise1, promise2]).then(function(result){
	      // result === 'promise 2' because it was resolved before promise1
	      // was resolved.
	    });
	    ```
	  
	    `Promise.race` is deterministic in that only the state of the first
	    settled promise matters. For example, even if other promises given to the
	    `promises` array argument are resolved, but the first settled promise has
	    become rejected before the other promises became fulfilled, the returned
	    promise will become rejected:
	  
	    ```javascript
	    let promise1 = new Promise(function(resolve, reject){
	      setTimeout(function(){
	        resolve('promise 1');
	      }, 200);
	    });
	  
	    let promise2 = new Promise(function(resolve, reject){
	      setTimeout(function(){
	        reject(new Error('promise 2'));
	      }, 100);
	    });
	  
	    Promise.race([promise1, promise2]).then(function(result){
	      // Code here never runs
	    }, function(reason){
	      // reason.message === 'promise 2' because promise 2 became rejected before
	      // promise 1 became fulfilled
	    });
	    ```
	  
	    An example real-world use case is implementing timeouts:
	  
	    ```javascript
	    Promise.race([ajax('foo.json'), timeout(5000)])
	    ```
	  
	    @method race
	    @static
	    @param {Array} promises array of promises to observe
	    Useful for tooling.
	    @return {Promise} a promise which settles in the same way as the first passed
	    promise to settle.
	  */


	  function race(entries) {
	    /*jshint validthis:true */
	    var Constructor = this;

	    if (!isArray(entries)) {
	      return new Constructor(function (_, reject) {
	        return reject(new TypeError('You must pass an array to race.'));
	      });
	    } else {
	      return new Constructor(function (resolve, reject) {
	        var length = entries.length;

	        for (var i = 0; i < length; i++) {
	          Constructor.resolve(entries[i]).then(resolve, reject);
	        }
	      });
	    }
	  }
	  /**
	    `Promise.reject` returns a promise rejected with the passed `reason`.
	    It is shorthand for the following:
	  
	    ```javascript
	    let promise = new Promise(function(resolve, reject){
	      reject(new Error('WHOOPS'));
	    });
	  
	    promise.then(function(value){
	      // Code here doesn't run because the promise is rejected!
	    }, function(reason){
	      // reason.message === 'WHOOPS'
	    });
	    ```
	  
	    Instead of writing the above, your code now simply becomes the following:
	  
	    ```javascript
	    let promise = Promise.reject(new Error('WHOOPS'));
	  
	    promise.then(function(value){
	      // Code here doesn't run because the promise is rejected!
	    }, function(reason){
	      // reason.message === 'WHOOPS'
	    });
	    ```
	  
	    @method reject
	    @static
	    @param {Any} reason value that the returned promise will be rejected with.
	    Useful for tooling.
	    @return {Promise} a promise rejected with the given `reason`.
	  */


	  function reject(reason) {
	    /*jshint validthis:true */
	    var Constructor = this;
	    var promise = new Constructor(noop);

	    _reject(promise, reason);

	    return promise;
	  }

	  function needsResolver() {
	    throw new TypeError('You must pass a resolver function as the first argument to the promise constructor');
	  }

	  function needsNew() {
	    throw new TypeError("Failed to construct 'Promise': Please use the 'new' operator, this object constructor cannot be called as a function.");
	  }
	  /**
	    Promise objects represent the eventual result of an asynchronous operation. The
	    primary way of interacting with a promise is through its `then` method, which
	    registers callbacks to receive either a promise's eventual value or the reason
	    why the promise cannot be fulfilled.
	  
	    Terminology
	    -----------
	  
	    - `promise` is an object or function with a `then` method whose behavior conforms to this specification.
	    - `thenable` is an object or function that defines a `then` method.
	    - `value` is any legal JavaScript value (including undefined, a thenable, or a promise).
	    - `exception` is a value that is thrown using the throw statement.
	    - `reason` is a value that indicates why a promise was rejected.
	    - `settled` the final resting state of a promise, fulfilled or rejected.
	  
	    A promise can be in one of three states: pending, fulfilled, or rejected.
	  
	    Promises that are fulfilled have a fulfillment value and are in the fulfilled
	    state.  Promises that are rejected have a rejection reason and are in the
	    rejected state.  A fulfillment value is never a thenable.
	  
	    Promises can also be said to *resolve* a value.  If this value is also a
	    promise, then the original promise's settled state will match the value's
	    settled state.  So a promise that *resolves* a promise that rejects will
	    itself reject, and a promise that *resolves* a promise that fulfills will
	    itself fulfill.
	  
	  
	    Basic Usage:
	    ------------
	  
	    ```js
	    let promise = new Promise(function(resolve, reject) {
	      // on success
	      resolve(value);
	  
	      // on failure
	      reject(reason);
	    });
	  
	    promise.then(function(value) {
	      // on fulfillment
	    }, function(reason) {
	      // on rejection
	    });
	    ```
	  
	    Advanced Usage:
	    ---------------
	  
	    Promises shine when abstracting away asynchronous interactions such as
	    `XMLHttpRequest`s.
	  
	    ```js
	    function getJSON(url) {
	      return new Promise(function(resolve, reject){
	        let xhr = new XMLHttpRequest();
	  
	        xhr.open('GET', url);
	        xhr.onreadystatechange = handler;
	        xhr.responseType = 'json';
	        xhr.setRequestHeader('Accept', 'application/json');
	        xhr.send();
	  
	        function handler() {
	          if (this.readyState === this.DONE) {
	            if (this.status === 200) {
	              resolve(this.response);
	            } else {
	              reject(new Error('getJSON: `' + url + '` failed with status: [' + this.status + ']'));
	            }
	          }
	        };
	      });
	    }
	  
	    getJSON('/posts.json').then(function(json) {
	      // on fulfillment
	    }, function(reason) {
	      // on rejection
	    });
	    ```
	  
	    Unlike callbacks, promises are great composable primitives.
	  
	    ```js
	    Promise.all([
	      getJSON('/posts'),
	      getJSON('/comments')
	    ]).then(function(values){
	      values[0] // => postsJSON
	      values[1] // => commentsJSON
	  
	      return values;
	    });
	    ```
	  
	    @class Promise
	    @param {function} resolver
	    Useful for tooling.
	    @constructor
	  */


	  function Promise(resolver) {
	    this[PROMISE_ID] = nextId();
	    this._result = this._state = undefined;
	    this._subscribers = [];

	    if (noop !== resolver) {
	      typeof resolver !== 'function' && needsResolver();
	      this instanceof Promise ? initializePromise(this, resolver) : needsNew();
	    }
	  }

	  Promise.all = all;
	  Promise.race = race;
	  Promise.resolve = resolve;
	  Promise.reject = reject;
	  Promise._setScheduler = setScheduler;
	  Promise._setAsap = setAsap;
	  Promise._asap = asap;
	  Promise.prototype = {
	    constructor: Promise,

	    /**
	      The primary way of interacting with a promise is through its `then` method,
	      which registers callbacks to receive either a promise's eventual value or the
	      reason why the promise cannot be fulfilled.
	    
	      ```js
	      findUser().then(function(user){
	        // user is available
	      }, function(reason){
	        // user is unavailable, and you are given the reason why
	      });
	      ```
	    
	      Chaining
	      --------
	    
	      The return value of `then` is itself a promise.  This second, 'downstream'
	      promise is resolved with the return value of the first promise's fulfillment
	      or rejection handler, or rejected if the handler throws an exception.
	    
	      ```js
	      findUser().then(function (user) {
	        return user.name;
	      }, function (reason) {
	        return 'default name';
	      }).then(function (userName) {
	        // If `findUser` fulfilled, `userName` will be the user's name, otherwise it
	        // will be `'default name'`
	      });
	    
	      findUser().then(function (user) {
	        throw new Error('Found user, but still unhappy');
	      }, function (reason) {
	        throw new Error('`findUser` rejected and we're unhappy');
	      }).then(function (value) {
	        // never reached
	      }, function (reason) {
	        // if `findUser` fulfilled, `reason` will be 'Found user, but still unhappy'.
	        // If `findUser` rejected, `reason` will be '`findUser` rejected and we're unhappy'.
	      });
	      ```
	      If the downstream promise does not specify a rejection handler, rejection reasons will be propagated further downstream.
	    
	      ```js
	      findUser().then(function (user) {
	        throw new PedagogicalException('Upstream error');
	      }).then(function (value) {
	        // never reached
	      }).then(function (value) {
	        // never reached
	      }, function (reason) {
	        // The `PedgagocialException` is propagated all the way down to here
	      });
	      ```
	    
	      Assimilation
	      ------------
	    
	      Sometimes the value you want to propagate to a downstream promise can only be
	      retrieved asynchronously. This can be achieved by returning a promise in the
	      fulfillment or rejection handler. The downstream promise will then be pending
	      until the returned promise is settled. This is called *assimilation*.
	    
	      ```js
	      findUser().then(function (user) {
	        return findCommentsByAuthor(user);
	      }).then(function (comments) {
	        // The user's comments are now available
	      });
	      ```
	    
	      If the assimliated promise rejects, then the downstream promise will also reject.
	    
	      ```js
	      findUser().then(function (user) {
	        return findCommentsByAuthor(user);
	      }).then(function (comments) {
	        // If `findCommentsByAuthor` fulfills, we'll have the value here
	      }, function (reason) {
	        // If `findCommentsByAuthor` rejects, we'll have the reason here
	      });
	      ```
	    
	      Simple Example
	      --------------
	    
	      Synchronous Example
	    
	      ```javascript
	      let result;
	    
	      try {
	        result = findResult();
	        // success
	      } catch(reason) {
	        // failure
	      }
	      ```
	    
	      Errback Example
	    
	      ```js
	      findResult(function(result, err){
	        if (err) {
	          // failure
	        } else {
	          // success
	        }
	      });
	      ```
	    
	      Promise Example;
	    
	      ```javascript
	      findResult().then(function(result){
	        // success
	      }, function(reason){
	        // failure
	      });
	      ```
	    
	      Advanced Example
	      --------------
	    
	      Synchronous Example
	    
	      ```javascript
	      let author, books;
	    
	      try {
	        author = findAuthor();
	        books  = findBooksByAuthor(author);
	        // success
	      } catch(reason) {
	        // failure
	      }
	      ```
	    
	      Errback Example
	    
	      ```js
	    
	      function foundBooks(books) {
	    
	      }
	    
	      function failure(reason) {
	    
	      }
	    
	      findAuthor(function(author, err){
	        if (err) {
	          failure(err);
	          // failure
	        } else {
	          try {
	            findBoooksByAuthor(author, function(books, err) {
	              if (err) {
	                failure(err);
	              } else {
	                try {
	                  foundBooks(books);
	                } catch(reason) {
	                  failure(reason);
	                }
	              }
	            });
	          } catch(error) {
	            failure(err);
	          }
	          // success
	        }
	      });
	      ```
	    
	      Promise Example;
	    
	      ```javascript
	      findAuthor().
	        then(findBooksByAuthor).
	        then(function(books){
	          // found books
	      }).catch(function(reason){
	        // something went wrong
	      });
	      ```
	    
	      @method then
	      @param {Function} onFulfilled
	      @param {Function} onRejected
	      Useful for tooling.
	      @return {Promise}
	    */
	    then: then,

	    /**
	      `catch` is simply sugar for `then(undefined, onRejection)` which makes it the same
	      as the catch block of a try/catch statement.
	    
	      ```js
	      function findAuthor(){
	        throw new Error('couldn't find that author');
	      }
	    
	      // synchronous
	      try {
	        findAuthor();
	      } catch(reason) {
	        // something went wrong
	      }
	    
	      // async with promises
	      findAuthor().catch(function(reason){
	        // something went wrong
	      });
	      ```
	    
	      @method catch
	      @param {Function} onRejection
	      Useful for tooling.
	      @return {Promise}
	    */
	    'catch': function _catch(onRejection) {
	      return this.then(null, onRejection);
	    }
	  };

	  function polyfill() {
	    var local = undefined;

	    if (typeof commonjsGlobal !== 'undefined') {
	      local = commonjsGlobal;
	    } else if (typeof self !== 'undefined') {
	      local = self;
	    } else {
	      try {
	        local = Function('return this')();
	      } catch (e) {
	        throw new Error('polyfill failed because global object is unavailable in this environment');
	      }
	    }

	    var P = local.Promise;

	    if (P) {
	      var promiseToString = null;

	      try {
	        promiseToString = Object.prototype.toString.call(P.resolve());
	      } catch (e) {// silently ignored
	      }

	      if (promiseToString === '[object Promise]' && !P.cast) {
	        return;
	      }
	    }

	    local.Promise = Promise;
	  } // Strange compat..


	  Promise.polyfill = polyfill;
	  Promise.Promise = Promise;
	  return Promise;
	});
	});

	var keys = createCommonjsModule(function (module, exports) {
	exports = module.exports = typeof Object.keys === 'function' ? Object.keys : shim;
	exports.shim = shim;

	function shim(obj) {
	  var keys = [];

	  for (var key in obj) {
	    keys.push(key);
	  }

	  return keys;
	}
	});
	var keys_1 = keys.shim;

	var is_arguments = createCommonjsModule(function (module, exports) {
	var supportsArgumentsClass = function () {
	  return Object.prototype.toString.call(arguments);
	}() == '[object Arguments]';

	exports = module.exports = supportsArgumentsClass ? supported : unsupported;
	exports.supported = supported;

	function supported(object) {
	  return Object.prototype.toString.call(object) == '[object Arguments]';
	}
	exports.unsupported = unsupported;

	function unsupported(object) {
	  return object && babelHelpers.typeof(object) == 'object' && typeof object.length == 'number' && Object.prototype.hasOwnProperty.call(object, 'callee') && !Object.prototype.propertyIsEnumerable.call(object, 'callee') || false;
	}
	});
	var is_arguments_1 = is_arguments.supported;
	var is_arguments_2 = is_arguments.unsupported;

	var deepEqual_1 = createCommonjsModule(function (module) {
	var pSlice = Array.prototype.slice;





	var deepEqual = module.exports = function (actual, expected, opts) {
	  if (!opts) opts = {}; // 7.1. All identical values are equivalent, as determined by ===.

	  if (actual === expected) {
	    return true;
	  } else if (actual instanceof Date && expected instanceof Date) {
	    return actual.getTime() === expected.getTime(); // 7.3. Other pairs that do not both pass typeof value == 'object',
	    // equivalence is determined by ==.
	  } else if (!actual || !expected || babelHelpers.typeof(actual) != 'object' && babelHelpers.typeof(expected) != 'object') {
	    return opts.strict ? actual === expected : actual == expected; // 7.4. For all other Object pairs, including Array objects, equivalence is
	    // determined by having the same number of owned properties (as verified
	    // with Object.prototype.hasOwnProperty.call), the same set of keys
	    // (although not necessarily the same order), equivalent values for every
	    // corresponding key, and an identical 'prototype' property. Note: this
	    // accounts for both named and indexed properties on Arrays.
	  } else {
	    return objEquiv(actual, expected, opts);
	  }
	};

	function isUndefinedOrNull(value) {
	  return value === null || value === undefined;
	}

	function isBuffer(x) {
	  if (!x || babelHelpers.typeof(x) !== 'object' || typeof x.length !== 'number') return false;

	  if (typeof x.copy !== 'function' || typeof x.slice !== 'function') {
	    return false;
	  }

	  if (x.length > 0 && typeof x[0] !== 'number') return false;
	  return true;
	}

	function objEquiv(a, b, opts) {
	  var i, key;
	  if (isUndefinedOrNull(a) || isUndefinedOrNull(b)) return false; // an identical 'prototype' property.

	  if (a.prototype !== b.prototype) return false; //~~~I've managed to break Object.keys through screwy arguments passing.
	  //   Converting to array solves the problem.

	  if (is_arguments(a)) {
	    if (!is_arguments(b)) {
	      return false;
	    }

	    a = pSlice.call(a);
	    b = pSlice.call(b);
	    return deepEqual(a, b, opts);
	  }

	  if (isBuffer(a)) {
	    if (!isBuffer(b)) {
	      return false;
	    }

	    if (a.length !== b.length) return false;

	    for (i = 0; i < a.length; i++) {
	      if (a[i] !== b[i]) return false;
	    }

	    return true;
	  }

	  try {
	    var ka = keys(a),
	        kb = keys(b);
	  } catch (e) {
	    //happens when one is a string literal and the other isn't
	    return false;
	  } // having the same number of owned properties (keys incorporates
	  // hasOwnProperty)


	  if (ka.length != kb.length) return false; //the same set of keys (although not necessarily the same order),

	  ka.sort();
	  kb.sort(); //~~~cheap key test

	  for (i = ka.length - 1; i >= 0; i--) {
	    if (ka[i] != kb[i]) return false;
	  } //equivalent values for every corresponding key, and
	  //~~~possibly expensive deep test


	  for (i = ka.length - 1; i >= 0; i--) {
	    key = ka[i];
	    if (!deepEqual(a[key], b[key], opts)) return false;
	  }

	  return babelHelpers.typeof(a) === babelHelpers.typeof(b);
	}
	});

	var templates = {
	  error: 'Error.',
	  required: 'Required.',
	  float: 'Must be a number.',
	  integer: 'Must be an integer.',
	  number: 'Must be a number.',
	  lessThan: 'Must be less than {0}.',
	  lessThanOrEqualTo: 'Must be less than or equal to {0}.',
	  greaterThan: 'Must be greater than {0}.',
	  greaterThanOrEqualTo: 'Must greater than or equal to {0}.',
	  between: 'Must be between {0} and {1}.',
	  size: 'Size must be {0}.',
	  length: 'Length must be {0}.',
	  minLength: 'Must have at least {0} characters.',
	  maxLength: 'Must have up to {0} characters.',
	  lengthBetween: 'Length must between {0} and {1}.',
	  in: 'Must be {0}.',
	  notIn: 'Must not be {0}.',
	  match: 'Not matched.',
	  regex: 'Invalid format.',
	  digit: 'Must be a digit.',
	  email: 'Invalid email.',
	  url: 'Invalid url.',
	  optionCombiner: function optionCombiner(options) {
	    if (options.length > 2) {
	      options = [options.slice(0, options.length - 1).join(', '), options[options.length - 1]];
	    }

	    return options.join(' or ');
	  }
	};

	var utils = createCommonjsModule(function (module) {

	 // This implementation of debounce was taken from the blog of David Walsh.
	// See here: https://davidwalsh.name/javascript-debounce-function


	module.exports.debounce = function (func, wait, immediate) {
	  var timeout;
	  return function () {
	    var context = this;
	    var args = arguments;

	    var later = function later() {
	      timeout = null;

	      if (!immediate) {
	        func.apply(context, args);
	      }
	    };

	    var callNow = immediate && !timeout;
	    clearTimeout(timeout);
	    timeout = setTimeout(later, wait);

	    if (callNow) {
	      func.apply(context, args);
	    }
	  };
	};

	module.exports.format = function (template) {
	  var args = Array.prototype.slice.call(arguments, 1);
	  return template.replace(/{(\d+)}/g, function (match, number) {
	    return typeof args[number] != 'undefined' ? args[number] : match;
	  });
	};

	module.exports.isArray = function (arg) {
	  if (typeof Array.isArray === 'function') {
	    return Array.isArray(arg);
	  }

	  return Object.prototype.toString.call(arg) === '[object Array]';
	};

	module.exports.isEmpty = function (value) {
	  if (module.exports.isArray(value)) {
	    return !value.length;
	  } else if (value === undefined || value === null) {
	    return true;
	  } else {
	    return !String(value).trim().length;
	  }
	};

	module.exports.isEqual = function (o1, o2) {
	  return deepEqual_1(o1, o2);
	};

	module.exports.isFunction = function (arg) {
	  return typeof arg === 'function';
	};

	module.exports.isNaN = function (arg) {
	  return /^\s*$/.test(arg) || isNaN(arg);
	};

	module.exports.isNull = function (arg) {
	  return arg === null;
	};

	module.exports.isString = function (arg) {
	  return typeof arg === 'string' || arg instanceof String;
	};

	module.exports.isUndefined = function (arg) {
	  return typeof arg === 'undefined';
	};

	module.exports.omit = function omit(obj, key) {
	  var result = {};

	  for (var name in obj) {
	    if (name !== key) {
	      result[name] = obj[name];
	    }
	  }

	  return result;
	};

	module.exports.templates = templates;
	module.exports.mode = 'interactive'; // other values: conservative and manual
	});
	var utils_1 = utils.debounce;
	var utils_2 = utils.format;
	var utils_3 = utils.isArray;
	var utils_4 = utils.isEmpty;
	var utils_5 = utils.isEqual;
	var utils_6 = utils.isFunction;
	var utils_7 = utils.isNaN;
	var utils_8 = utils.isNull;
	var utils_9 = utils.isString;
	var utils_10 = utils.isUndefined;
	var utils_11 = utils.omit;
	var utils_12 = utils.templates;
	var utils_13 = utils.mode;

	var Promise$1 = es6Promise.Promise;



	function ValidationBag() {
	  this.sessionId = 0; // async validator will check this before adding error

	  this.resetting = 0; // do not allow to add error while reset is in progress

	  this.errors = [];
	  this.validatingRecords = [];
	  this.passedRecords = [];
	  this.touchedRecords = [];
	  this.activated = false; // set when $validate() is call, this flag works with the conservative mode
	}

	ValidationBag.prototype._setVM = function (vm) {
	  this._vm = vm;
	};

	ValidationBag.prototype.addError = function (field, message) {
	  if (this.resetting) {
	    return;
	  }

	  this.errors.push({
	    field: field,
	    message: message
	  });
	};

	ValidationBag.prototype.removeErrors = function (field) {
	  if (utils.isUndefined(field)) {
	    this.errors = [];
	  } else {
	    this.errors = this.errors.filter(function (e) {
	      return e.field !== field;
	    });
	  }
	};

	ValidationBag.prototype.hasError = function (field) {
	  return utils.isUndefined(field) ? !!this.errors.length : !!this.firstError(field);
	};

	ValidationBag.prototype.firstError = function (field) {
	  for (var i = 0; i < this.errors.length; i++) {
	    if (utils.isUndefined(field) || this.errors[i].field === field) {
	      return this.errors[i].message;
	    }
	  }

	  return null;
	};

	ValidationBag.prototype.allErrors = function (field) {
	  return this.errors.filter(function (e) {
	    return utils.isUndefined(field) || e.field === field;
	  }).map(function (e) {
	    return e.message;
	  });
	};

	ValidationBag.prototype.countErrors = function (field) {
	  return utils.isUndefined(field) ? this.errors.length : this.errors.filter(function (e) {
	    return field === e.field;
	  }).length;
	};

	ValidationBag.prototype.setValidating = function (field, id) {
	  if (this.resetting) {
	    return;
	  }

	  id = id || ValidationBag.newValidatingId();
	  var existingValidatingRecords = this.validatingRecords.filter(function (validating) {
	    return validating.field === field && validating.id === id;
	  });

	  if (!utils.isEmpty(existingValidatingRecords)) {
	    throw new Error('Validating id already set: ' + id);
	  }

	  this.validatingRecords.push({
	    field: field,
	    id: id
	  });
	  return id;
	};

	ValidationBag.prototype.resetValidating = function (field, id) {
	  if (!field) {
	    this.validatingRecords = [];
	    return;
	  }

	  function idMatched(validating) {
	    return utils.isUndefined(id) ? true : validating.id === id;
	  }

	  var hasMore = true;

	  while (hasMore) {
	    var index = -1;

	    for (var i = 0; i < this.validatingRecords.length; i++) {
	      if (this.validatingRecords[i].field === field && idMatched(this.validatingRecords[i])) {
	        index = i;
	        break;
	      }
	    }

	    if (index >= 0) {
	      this.validatingRecords.splice(index, 1);
	    } else {
	      hasMore = false;
	    }
	  }
	};

	ValidationBag.prototype.isValidating = function (field, id) {
	  function idMatched(validating) {
	    return utils.isUndefined(id) ? true : validating.id === id;
	  }

	  var existingValidatingRecords = this.validatingRecords.filter(function (validating) {
	    return (utils.isUndefined(field) || validating.field === field) && idMatched(validating);
	  });
	  return !utils.isEmpty(existingValidatingRecords);
	};

	ValidationBag.prototype.setPassed = function (field) {
	  if (this.resetting) {
	    return;
	  }

	  setValue(this.passedRecords, field);
	};

	ValidationBag.prototype.resetPassed = function (field) {
	  resetValue(this.passedRecords, field);
	};

	ValidationBag.prototype.isPassed = function (field) {
	  return isValueSet(this.passedRecords, field);
	};

	ValidationBag.prototype.setTouched = function (field) {
	  if (this.resetting) {
	    return;
	  }

	  setValue(this.touchedRecords, field);
	};

	ValidationBag.prototype.resetTouched = function (field) {
	  resetValue(this.touchedRecords, field);
	};

	ValidationBag.prototype.isTouched = function (field) {
	  return isValueSet(this.touchedRecords, field);
	};

	function setValue(records, field) {
	  var existingRecords = records.filter(function (record) {
	    return record.field === field;
	  });

	  if (!utils.isEmpty(existingRecords)) {
	    existingRecords[0].value = true;
	  } else {
	    records.push({
	      field: field,
	      value: true
	    });
	  }
	}

	function resetValue(records, field) {
	  if (!field) {
	    records.splice(0, records.length);
	    return;
	  }

	  var existingRecords = records.filter(function (record) {
	    return record.field === field;
	  });

	  if (!utils.isEmpty(existingRecords)) {
	    existingRecords[0].value = false;
	  }
	}

	function isValueSet(records, field) {
	  var existingRecords = records.filter(function (record) {
	    return record.field === field;
	  });
	  return !utils.isEmpty(existingRecords) && existingRecords[0].value;
	}

	ValidationBag.prototype.reset = function () {
	  this.sessionId++;
	  this.errors = [];
	  this.validatingRecords = [];
	  this.passedRecords = [];
	  this.touchedRecords = [];

	  if (this._vm) {
	    // prevent field updates at the same tick to change validation status
	    this.resetting++;

	    this._vm.$nextTick(function () {
	      this.resetting--;
	    }.bind(this));
	  }

	  this.activated = false;
	}; // returns true if any error is added


	ValidationBag.prototype.setError = function (field, message) {
	  if (this.resetting) {
	    return;
	  }

	  this.removeErrors(field);
	  this.resetPassed(field);
	  var messages = utils.isArray(message) ? message : [message];

	  var addMessages = function (messages) {
	    var hasError = false;
	    messages.forEach(function (message) {
	      if (message) {
	        this.addError(field, message);
	        hasError = true;
	      }
	    }, this);

	    if (!hasError) {
	      this.setPassed(field);
	    }

	    return hasError;
	  }.bind(this);

	  var hasPromise = messages.filter(function (message) {
	    return message && message.then;
	  }).length > 0;

	  if (!hasPromise) {
	    return Promise$1.resolve(addMessages(messages));
	  } else {
	    // if message is promise, we are encountering async validation, set validating flag and wait for message to resolve
	    // reset previous validating status for this field
	    this.resetValidating(field);
	    var validatingId = this.setValidating(field);

	    var always = function () {
	      //console.log(validatingId + ' | ' + 'end');
	      this.resetValidating(field, validatingId);
	    }.bind(this); //console.log(validatingId + ' | ' + 'start');


	    return Promise$1.all(messages).then(function (messages) {
	      // check if the validating id is is still valid
	      if (this.isValidating(field, validatingId)) {
	        //console.log(validatingId + ' | ' + 'processed');
	        return addMessages(messages);
	      }

	      return false;
	    }.bind(this)).then(function (result) {
	      always();
	      return result;
	    }).catch(function (e) {
	      always();
	      return Promise$1.reject(e);
	    }.bind(this));
	  }
	};

	ValidationBag.prototype.checkRule = function (rule) {
	  if (this.resetting) {
	    return;
	  }

	  return this.setError(rule._field, rule._messages);
	};

	var validatingId = 0;

	ValidationBag.newValidatingId = function () {
	  return (++validatingId).toString();
	};

	var validationBag = ValidationBag;

	function Rule(templates) {
	  this._field = '';
	  this._value = undefined;
	  this._messages = [];

	  if (templates) {
	    // merge given templates and utils.templates
	    this.templates = {};
	    Object.keys(utils.templates).forEach(function (key) {
	      this.templates[key] = utils.templates[key];
	    }.bind(this));
	    Object.keys(templates).forEach(function (key) {
	      this.templates[key] = templates[key];
	    }.bind(this));
	  } else {
	    this.templates = utils.templates;
	  }
	}

	Rule.prototype.field = function (field) {
	  this._field = field;
	  return this;
	};

	Rule.prototype.value = function (value) {
	  this._value = value;
	  return this;
	};

	Rule.prototype.custom = function (callback, context) {
	  var message = context ? callback.call(context) : callback();

	  if (message) {
	    if (message.then) {
	      var that = this;
	      message = Promise.resolve(message).then(function (result) {
	        return result;
	      }).catch(function (e) {
	        console.error(e.toString());
	        return that.templates.error;
	      });
	    }

	    this._messages.push(message);
	  }

	  return this;
	};

	Rule.prototype._checkValue = function () {
	  if (this._value === undefined) {
	    throw new Error('Validator.value not set');
	  }

	  return this._value;
	};

	Rule.prototype.required = function (message) {
	  var value = this._checkValue();

	  if (utils.isEmpty(value)) {
	    this._messages.push(message || this.templates.required);
	  }

	  return this;
	};

	Rule.prototype.float = function (message) {
	  var value = this._checkValue();

	  var regex = /^([-+])?([0-9]+(\.[0-9]+)?|Infinity)$/;

	  if (!utils.isEmpty(value) && !regex.test(value)) {
	    this._messages.push(message || this.templates.float);
	  }

	  return this;
	};

	Rule.prototype.integer = function (message) {
	  var value = this._checkValue();

	  var regex = /^([-+])?([0-9]+|Infinity)$/;

	  if (!utils.isEmpty(value) && !regex.test(value)) {
	    this._messages.push(message || this.templates.integer);
	  }

	  return this;
	};

	Rule.prototype.lessThan = function (bound, message) {
	  var value = this._checkValue();

	  if (!utils.isEmpty(value)) {
	    var number = parseFloat(value);

	    if (utils.isNaN(number)) {
	      this._messages.push(message || this.templates.number);
	    } else if (number >= bound) {
	      this._messages.push(message || utils.format(this.templates.lessThan, bound));
	    }
	  }

	  return this;
	};

	Rule.prototype.lessThanOrEqualTo = function (bound, message) {
	  var value = this._checkValue();

	  if (!utils.isEmpty(value)) {
	    var number = parseFloat(value);

	    if (utils.isNaN(number)) {
	      this._messages.push(message || this.templates.number);
	    } else if (number > bound) {
	      this._messages.push(message || utils.format(this.templates.lessThanOrEqualTo, bound));
	    }
	  }

	  return this;
	};

	Rule.prototype.greaterThan = function (bound, message) {
	  var value = this._checkValue();

	  if (!utils.isEmpty(value)) {
	    var number = parseFloat(value);

	    if (utils.isNaN(number)) {
	      this._messages.push(message || this.templates.number);
	    } else if (number <= bound) {
	      this._messages.push(message || utils.format(this.templates.greaterThan, bound));
	    }
	  }

	  return this;
	};

	Rule.prototype.greaterThanOrEqualTo = function (bound, message) {
	  var value = this._checkValue();

	  if (!utils.isEmpty(value)) {
	    var number = parseFloat(value);

	    if (utils.isNaN(number)) {
	      this._messages.push(message || this.templates.number);
	    } else if (number < bound) {
	      this._messages.push(message || utils.format(this.templates.greaterThanOrEqualTo, bound));
	    }
	  }

	  return this;
	};

	Rule.prototype.between = function (lowBound, highBound, message) {
	  var value = this._checkValue();

	  if (!utils.isEmpty(value)) {
	    var number = parseFloat(value);

	    if (utils.isNaN(number)) {
	      this._messages.push(message || this.templates.number);
	    } else if (number < lowBound || number > highBound) {
	      this._messages.push(message || utils.format(this.templates.between, lowBound, highBound));
	    }
	  }

	  return this;
	};

	Rule.prototype.size = function (size, message) {
	  var value = this._checkValue();

	  if (!utils.isEmpty(value) && utils.isArray(value) && value.length !== size) {
	    this._messages.push(message || utils.format(this.templates.size, size));
	  }

	  return this;
	};

	Rule.prototype.length = function (length, message) {
	  var value = this._checkValue();

	  if (!utils.isEmpty(value) && String(value).length !== length) {
	    this._messages.push(message || utils.format(this.templates.length, length));
	  }

	  return this;
	};

	Rule.prototype.minLength = function (length, message) {
	  var value = this._checkValue();

	  if (!utils.isEmpty(value) && String(value).length < length) {
	    this._messages.push(message || utils.format(this.templates.minLength, length));
	  }

	  return this;
	};

	Rule.prototype.maxLength = function (length, message) {
	  var value = this._checkValue();

	  if (!utils.isEmpty(value) && String(value).length > length) {
	    this._messages.push(message || utils.format(this.templates.maxLength, length));
	  }

	  return this;
	};

	Rule.prototype.lengthBetween = function (minLength, maxLength, message) {
	  var value = this._checkValue();

	  if (!utils.isEmpty(value)) {
	    var string = String(value);

	    if (string.length < minLength || string.length > maxLength) {
	      this._messages.push(message || utils.format(this.templates.lengthBetween, minLength, maxLength));
	    }
	  }

	  return this;
	};

	Rule.prototype.in = function (options, message) {
	  var value = this._checkValue();

	  if (!utils.isEmpty(value) && options.indexOf(value) < 0) {
	    this._messages.push(message || utils.format(this.templates.in, this.templates.optionCombiner(options)));
	  }

	  return this;
	};

	Rule.prototype.notIn = function (options, message) {
	  var value = this._checkValue();

	  if (!utils.isEmpty(value) && options.indexOf(value) >= 0) {
	    this._messages.push(message || utils.format(this.templates.notIn, this.templates.optionCombiner(options)));
	  }

	  return this;
	};

	Rule.prototype.match = function (valueToCompare, message) {
	  var value = this._checkValue();

	  if (!utils.isEmpty(value) && value !== valueToCompare) {
	    this._messages.push(message || this.templates.match);
	  }

	  return this;
	};

	Rule.prototype.regex = function (regex, message) {
	  var value = this._checkValue();

	  if (!utils.isEmpty(value)) {
	    if (utils.isString(regex)) {
	      regex = new RegExp(regex);
	    }

	    if (!regex.test(value)) {
	      this._messages.push(message || this.templates.regex);
	    }
	  }

	  return this;
	};

	Rule.prototype.digit = function (message) {
	  return this.regex(/^\d*$/, message || this.templates.digit);
	};

	Rule.prototype.email = function (message) {
	  return this.regex(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/, message || this.templates.email);
	};

	Rule.prototype.url = function (message) {
	  return this.regex(/(http|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?/, message || this.templates.url);
	};

	Rule.prototype.hasImmediateError = function () {
	  for (var i = 0; i < this._messages.length; i++) {
	    if (this._messages[i] && !this._messages[i].then) {
	      return true;
	    }
	  }

	  return false;
	};

	var rule = Rule;

	var Validator = newValidator();

	Validator.create = function (options) {
	  return newValidator(options);
	};

	function newValidator(options) {
	  options = options || {};
	  var validator = {}; // clone methods from Rule to validator

	  Object.keys(rule.prototype).forEach(function (methodName) {
	    validator[methodName] = function () {
	      var rule$$1 = new rule(options.templates);
	      return rule$$1[methodName].apply(rule$$1, arguments);
	    };
	  });
	  validator.isEmpty = utils.isEmpty;
	  validator.format = utils.format;
	  return validator;
	}

	var validator = Validator;

	var mixin = {
	  Promise: null,
	  beforeMount: function beforeMount() {
	    this.$setValidators(this.$options.validators);

	    if (this.validation) {
	      // set vm to validation
	      this.validation._setVM(this);
	    }
	  },
	  beforeDestroy: function beforeDestroy() {
	    unwatch(this.$options.validatorsUnwatchCallbacks);
	  },
	  data: function data() {
	    if (this.$options.validators) {
	      return {
	        validation: new validationBag()
	      };
	    }

	    return {};
	  },
	  methods: {
	    $setValidators: function $setValidators(validators) {
	      unwatch(this.$options.validatorsUnwatchCallbacks); // validate methods contains all application validate codes

	      var validateMethods = {};
	      this.$options.validateMethods = validateMethods;
	      var unwatchCallbacks = [];
	      this.$options.validatorsUnwatchCallbacks = unwatchCallbacks; // generate validate methods and watch properties change for validators

	      if (validators) {
	        Object.keys(validators).forEach(function (key) {
	          var properties = key.split(',');
	          properties = properties.map(function (property) {
	            return property.trim();
	          });
	          var getters = properties.map(function (property) {
	            return generateGetter(this, property);
	          }, this);
	          var validator = validators[key];
	          var options = {};

	          if (!utils.isFunction(validator)) {
	            options = utils.omit(validator, 'validator');
	            validator = validator.validator;
	          }

	          if (options.cache) {
	            // cache the validation result, so that async validator can be fast when submitting the form
	            var option = options.cache === 'last' ? 'last' : 'all';
	            validator = cache(validator, option);
	          }

	          var validation = this.validation;

	          var validateMethod = function () {
	            if (utils.mode === 'conservative' && !validation.activated) {
	              // do nothing if in conservative mode and $validate() method is not called before
	              return getPromise().resolve(false);
	            }

	            var args = getters.map(function (getter) {
	              return getter();
	            });
	            var rule = validator.apply(this, args);

	            if (rule) {
	              if (!rule._field) {
	                // field defaults to the first property
	                rule.field(properties[0]);
	              }

	              return this.validation.checkRule(rule);
	            } else {
	              return getPromise().resolve(false);
	            }
	          }.bind(this); // add to validate method list


	          validateMethods[properties[0]] = validateMethod; // watch change and invoke validate method

	          var validateMethodForWatch = validateMethod;

	          if (options.debounce) {
	            // TODO what if custom field name is used?
	            var decoratedValidateMethod = function () {
	              if (decoratedValidateMethod.sessionId !== this.validation.sessionId) {
	                // skip validation if it's reset before
	                return getPromise().resolve(false);
	              }

	              return validateMethod.apply(this, arguments);
	            }.bind(this);

	            var debouncedValidateMethod = utils.debounce(decoratedValidateMethod, parseInt(options.debounce));
	            var field = properties[0];

	            validateMethodForWatch = function () {
	              // eagerly resetting passed flag if debouncing is used.
	              this.validation.resetPassed(field); // store sessionId

	              decoratedValidateMethod.sessionId = this.validation.sessionId;
	              debouncedValidateMethod.apply(this, arguments);
	            }.bind(this);
	          }

	          if (utils.mode !== 'manual') {
	            // have to call $validate() to trigger validation in manual mode, so don't watch,
	            watchProperties(this, properties, validateMethodForWatch).forEach(function (unwatch) {
	              unwatchCallbacks.push(unwatch);
	            });
	          }
	        }, this);
	      }
	    },
	    $validate: function $validate(fields) {
	      if (this.validation._validate) {
	        return this.validation._validate;
	      }

	      this.validation.activated = true;
	      var validateMethods = this.$options.validateMethods;

	      if (utils.isUndefined(fields)) {
	        validateMethods = Object.keys(validateMethods).map(function (key) {
	          return validateMethods[key];
	        });
	      } else {
	        fields = utils.isArray(fields) ? fields : [fields];
	        validateMethods = fields.map(function (field) {
	          return validateMethods[field];
	        });
	      }

	      if (utils.isEmpty(validateMethods)) {
	        return getPromise().resolve(true);
	      } else {
	        var always = function () {
	          this.validation._validate = null;
	        }.bind(this);

	        this.validation._validate = getPromise().all(validateMethods.map(function (validateMethod) {
	          return validateMethod();
	        })).then(function (results) {
	          always();
	          return results.filter(function (result) {
	            return !!result;
	          }).length <= 0;
	        }.bind(this)).catch(function (e) {
	          always();
	          throw e;
	        });
	        return this.validation._validate;
	      }
	    }
	  }
	};

	function unwatch(list) {
	  if (list) {
	    list.forEach(function (unwatch) {
	      unwatch();
	    });
	  }
	}

	function generateGetter(vm, property) {
	  var names = property.split('.');
	  return function () {
	    var value = vm;

	    for (var i = 0; i < names.length; i++) {
	      if (utils.isNull(value) || utils.isUndefined(value)) {
	        break;
	      }

	      value = value[names[i]];
	    }

	    return value;
	  };
	}

	function watchProperties(vm, properties, callback) {
	  return properties.map(function (property) {
	    return vm.$watch(property, function () {
	      vm.validation.setTouched(property);
	      callback.call();
	    });
	  });
	}

	function cache(validator, option) {
	  return function () {
	    var cache = validator.cache;

	    if (!cache) {
	      cache = [];
	      validator.cache = cache;
	    }

	    var args = Array.prototype.slice.call(arguments);
	    var cachedResult = findInCache(cache, args);

	    if (!utils.isUndefined(cachedResult)) {
	      return cachedResult;
	    }

	    var result = validator.apply(this, args);

	    if (!utils.isUndefined(result)) {
	      if (result.then) {
	        return result.tab(function (promiseResult) {
	          if (!utils.isUndefined(promiseResult)) {
	            if (option !== 'all') {
	              cache.splice(0, cache.length);
	            }

	            cache.push({
	              args: args,
	              result: promiseResult
	            });
	          }
	        });
	      } else {
	        if (option !== 'all') {
	          cache.splice(0, cache.length);
	        }

	        cache.push({
	          args: args,
	          result: result
	        });
	        return result;
	      }
	    }
	  };
	}

	function getPromise() {
	  if (mixin.Promise) {
	    return mixin.Promise;
	  }

	  return es6Promise.Promise;
	}

	function findInCache(cache, args) {
	  var items = cache.filter(function (item) {
	    return utils.isEqual(args, item.args);
	  });

	  if (!utils.isEmpty(items)) {
	    return items[0].result;
	  }
	}

	var mixin_1 = mixin;

	/* plugin install
	 ----------------------------------- */


	function install(Vue, options) {
	  Vue.mixin(mixin_1);

	  if (options && options.templates) {
	    extendTemplates(options.templates);
	  }

	  if (options && options.mode) {
	    setMode(options.mode);
	  }

	  if (options && options.Promise) {
	    mixin_1.Promise = options.Promise;
	  }
	}

	function extendTemplates(newTemplates) {
	  Object.keys(newTemplates).forEach(function (key) {
	    utils.templates[key] = newTemplates[key];
	  });
	}

	function setMode(mode) {
	  if (mode !== 'interactive' && mode !== 'conservative' && mode !== 'manual') {
	    throw new Error('Invalid mode: ' + mode);
	  }

	  utils.mode = mode;
	}
	/* exports
	 ----------------------------------- */


	var name = 'SimpleVueValidator';
	var ValidationBag_1 = validationBag;
	var Rule_1 = rule;
	var Validator_1 = validator;
	var mixin_1$1 = mixin_1;
	var install_1 = install;
	var extendTemplates_1 = extendTemplates;
	var setMode_1 = setMode;

	var src = {
		name: name,
		ValidationBag: ValidationBag_1,
		Rule: Rule_1,
		Validator: Validator_1,
		mixin: mixin_1$1,
		install: install_1,
		extendTemplates: extendTemplates_1,
		setMode: setMode_1
	};

	function extend(dest, src) {
	  if (src) {
	    var props = Object.keys(src);

	    for (var i = 0, l = props.length; i < l; i++) {
	      dest[props[i]] = src[props[i]];
	    }
	  }

	  return dest;
	}

	function copy(obj) {
	  return extend({}, obj);
	}
	/**
	 * Merge an object defining format characters into the defaults.
	 * Passing null/undefined for en existing format character removes it.
	 * Passing a definition for an existing format character overrides it.
	 * @param {?Object} formatCharacters.
	 */


	function mergeFormatCharacters(formatCharacters) {
	  var merged = copy(DEFAULT_FORMAT_CHARACTERS);

	  if (formatCharacters) {
	    var chars = Object.keys(formatCharacters);

	    for (var i = 0, l = chars.length; i < l; i++) {
	      var char = chars[i];

	      if (formatCharacters[char] == null) {
	        delete merged[char];
	      } else {
	        merged[char] = formatCharacters[char];
	      }
	    }
	  }

	  return merged;
	}

	var ESCAPE_CHAR = '\\';
	var DIGIT_RE = /^\d$/;
	var LETTER_RE = /^[A-Za-z]$/;
	var ALPHANNUMERIC_RE = /^[\dA-Za-z]$/;
	var DEFAULT_PLACEHOLDER_CHAR = '_';
	var DEFAULT_FORMAT_CHARACTERS = {
	  '*': {
	    validate: function validate(char) {
	      return ALPHANNUMERIC_RE.test(char);
	    }
	  },
	  '1': {
	    validate: function validate(char) {
	      return DIGIT_RE.test(char);
	    }
	  },
	  'a': {
	    validate: function validate(char) {
	      return LETTER_RE.test(char);
	    }
	  },
	  'A': {
	    validate: function validate(char) {
	      return LETTER_RE.test(char);
	    },
	    transform: function transform(char) {
	      return char.toUpperCase();
	    }
	  },
	  '#': {
	    validate: function validate(char) {
	      return ALPHANNUMERIC_RE.test(char);
	    },
	    transform: function transform(char) {
	      return char.toUpperCase();
	    }
	  }
	};
	/**
	 * @param {string} source
	 * @patam {?Object} formatCharacters
	 */

	function Pattern(source, formatCharacters, placeholderChar, isRevealingMask) {
	  if (!(this instanceof Pattern)) {
	    return new Pattern(source, formatCharacters, placeholderChar);
	  }
	  /** Placeholder character */


	  this.placeholderChar = placeholderChar || DEFAULT_PLACEHOLDER_CHAR;
	  /** Format character definitions. */

	  this.formatCharacters = formatCharacters || DEFAULT_FORMAT_CHARACTERS;
	  /** Pattern definition string with escape characters. */

	  this.source = source;
	  /** Pattern characters after escape characters have been processed. */

	  this.pattern = [];
	  /** Length of the pattern after escape characters have been processed. */

	  this.length = 0;
	  /** Index of the first editable character. */

	  this.firstEditableIndex = null;
	  /** Index of the last editable character. */

	  this.lastEditableIndex = null;
	  /** Lookup for indices of editable characters in the pattern. */

	  this._editableIndices = {};
	  /** If true, only the pattern before the last valid value character shows. */

	  this.isRevealingMask = isRevealingMask || false;

	  this._parse();
	}

	Pattern.prototype._parse = function parse() {
	  var sourceChars = this.source.split('');
	  var patternIndex = 0;
	  var pattern = [];

	  for (var i = 0, l = sourceChars.length; i < l; i++) {
	    var char = sourceChars[i];

	    if (char === ESCAPE_CHAR) {
	      if (i === l - 1) {
	        throw new Error('InputMask: pattern ends with a raw ' + ESCAPE_CHAR);
	      }

	      char = sourceChars[++i];
	    } else if (char in this.formatCharacters) {
	      if (this.firstEditableIndex === null) {
	        this.firstEditableIndex = patternIndex;
	      }

	      this.lastEditableIndex = patternIndex;
	      this._editableIndices[patternIndex] = true;
	    }

	    pattern.push(char);
	    patternIndex++;
	  }

	  if (this.firstEditableIndex === null) {
	    throw new Error('InputMask: pattern "' + this.source + '" does not contain any editable characters.');
	  }

	  this.pattern = pattern;
	  this.length = pattern.length;
	};
	/**
	 * @param {Array<string>} value
	 * @return {Array<string>}
	 */


	Pattern.prototype.formatValue = function format(value) {
	  var valueBuffer = new Array(this.length);
	  var valueIndex = 0;

	  for (var i = 0, l = this.length; i < l; i++) {
	    if (this.isEditableIndex(i)) {
	      if (this.isRevealingMask && value.length <= valueIndex && !this.isValidAtIndex(value[valueIndex], i)) {
	        break;
	      }

	      valueBuffer[i] = value.length > valueIndex && this.isValidAtIndex(value[valueIndex], i) ? this.transform(value[valueIndex], i) : this.placeholderChar;
	      valueIndex++;
	    } else {
	      valueBuffer[i] = this.pattern[i]; // Also allow the value to contain static values from the pattern by
	      // advancing its index.

	      if (value.length > valueIndex && value[valueIndex] === this.pattern[i]) {
	        valueIndex++;
	      }
	    }
	  }

	  return valueBuffer;
	};
	/**
	 * @param {number} index
	 * @return {boolean}
	 */


	Pattern.prototype.isEditableIndex = function isEditableIndex(index) {
	  return !!this._editableIndices[index];
	};
	/**
	 * @param {string} char
	 * @param {number} index
	 * @return {boolean}
	 */


	Pattern.prototype.isValidAtIndex = function isValidAtIndex(char, index) {
	  return this.formatCharacters[this.pattern[index]].validate(char);
	};

	Pattern.prototype.transform = function transform(char, index) {
	  var format = this.formatCharacters[this.pattern[index]];
	  return typeof format.transform == 'function' ? format.transform(char) : char;
	};

	function InputMask(options) {
	  if (!(this instanceof InputMask)) {
	    return new InputMask(options);
	  }

	  options = extend({
	    formatCharacters: null,
	    pattern: null,
	    isRevealingMask: false,
	    placeholderChar: DEFAULT_PLACEHOLDER_CHAR,
	    selection: {
	      start: 0,
	      end: 0
	    },
	    value: ''
	  }, options);

	  if (options.pattern == null) {
	    throw new Error('InputMask: you must provide a pattern.');
	  }

	  if (typeof options.placeholderChar !== 'string' || options.placeholderChar.length > 1) {
	    throw new Error('InputMask: placeholderChar should be a single character or an empty string.');
	  }

	  this.placeholderChar = options.placeholderChar;
	  this.formatCharacters = mergeFormatCharacters(options.formatCharacters);
	  this.setPattern(options.pattern, {
	    value: options.value,
	    selection: options.selection,
	    isRevealingMask: options.isRevealingMask
	  });
	} // Editing

	/**
	 * Applies a single character of input based on the current selection.
	 * @param {string} char
	 * @return {boolean} true if a change has been made to value or selection as a
	 *   result of the input, false otherwise.
	 */


	InputMask.prototype.input = function input(char) {
	  // Ignore additional input if the cursor's at the end of the pattern
	  if (this.selection.start === this.selection.end && this.selection.start === this.pattern.length) {
	    return false;
	  }

	  var selectionBefore = copy(this.selection);
	  var valueBefore = this.getValue();
	  var inputIndex = this.selection.start; // If the cursor or selection is prior to the first editable character, make
	  // sure any input given is applied to it.

	  if (inputIndex < this.pattern.firstEditableIndex) {
	    inputIndex = this.pattern.firstEditableIndex;
	  } // Bail out or add the character to input


	  if (this.pattern.isEditableIndex(inputIndex)) {
	    if (!this.pattern.isValidAtIndex(char, inputIndex)) {
	      return false;
	    }

	    this.value[inputIndex] = this.pattern.transform(char, inputIndex);
	  } // If multiple characters were selected, blank the remainder out based on the
	  // pattern.


	  var end = this.selection.end - 1;

	  while (end > inputIndex) {
	    if (this.pattern.isEditableIndex(end)) {
	      this.value[end] = this.placeholderChar;
	    }

	    end--;
	  } // Advance the cursor to the next character


	  this.selection.start = this.selection.end = inputIndex + 1; // Skip over any subsequent static characters

	  while (this.pattern.length > this.selection.start && !this.pattern.isEditableIndex(this.selection.start)) {
	    this.selection.start++;
	    this.selection.end++;
	  } // History


	  if (this._historyIndex != null) {
	    // Took more input after undoing, so blow any subsequent history away
	    this._history.splice(this._historyIndex, this._history.length - this._historyIndex);

	    this._historyIndex = null;
	  }

	  if (this._lastOp !== 'input' || selectionBefore.start !== selectionBefore.end || this._lastSelection !== null && selectionBefore.start !== this._lastSelection.start) {
	    this._history.push({
	      value: valueBefore,
	      selection: selectionBefore,
	      lastOp: this._lastOp
	    });
	  }

	  this._lastOp = 'input';
	  this._lastSelection = copy(this.selection);
	  return true;
	};
	/**
	 * Attempts to delete from the value based on the current cursor position or
	 * selection.
	 * @return {boolean} true if the value or selection changed as the result of
	 *   backspacing, false otherwise.
	 */


	InputMask.prototype.backspace = function backspace() {
	  // If the cursor is at the start there's nothing to do
	  if (this.selection.start === 0 && this.selection.end === 0) {
	    return false;
	  }

	  var selectionBefore = copy(this.selection);
	  var valueBefore = this.getValue(); // No range selected - work on the character preceding the cursor

	  if (this.selection.start === this.selection.end) {
	    if (this.pattern.isEditableIndex(this.selection.start - 1)) {
	      this.value[this.selection.start - 1] = this.placeholderChar;
	    }

	    this.selection.start--;
	    this.selection.end--;
	  } // Range selected - delete characters and leave the cursor at the start of the selection
	  else {
	      var end = this.selection.end - 1;

	      while (end >= this.selection.start) {
	        if (this.pattern.isEditableIndex(end)) {
	          this.value[end] = this.placeholderChar;
	        }

	        end--;
	      }

	      this.selection.end = this.selection.start;
	    } // History


	  if (this._historyIndex != null) {
	    // Took more input after undoing, so blow any subsequent history away
	    this._history.splice(this._historyIndex, this._history.length - this._historyIndex);
	  }

	  if (this._lastOp !== 'backspace' || selectionBefore.start !== selectionBefore.end || this._lastSelection !== null && selectionBefore.start !== this._lastSelection.start) {
	    this._history.push({
	      value: valueBefore,
	      selection: selectionBefore,
	      lastOp: this._lastOp
	    });
	  }

	  this._lastOp = 'backspace';
	  this._lastSelection = copy(this.selection);
	  return true;
	};
	/**
	 * Attempts to paste a string of input at the current cursor position or over
	 * the top of the current selection.
	 * Invalid content at any position will cause the paste to be rejected, and it
	 * may contain static parts of the mask's pattern.
	 * @param {string} input
	 * @return {boolean} true if the paste was successful, false otherwise.
	 */


	InputMask.prototype.paste = function paste(input) {
	  // This is necessary because we're just calling input() with each character
	  // and rolling back if any were invalid, rather than checking up-front.
	  var initialState = {
	    value: this.value.slice(),
	    selection: copy(this.selection),
	    _lastOp: this._lastOp,
	    _history: this._history.slice(),
	    _historyIndex: this._historyIndex,
	    _lastSelection: copy(this._lastSelection)
	  }; // If there are static characters at the start of the pattern and the cursor
	  // or selection is within them, the static characters must match for a valid
	  // paste.

	  if (this.selection.start < this.pattern.firstEditableIndex) {
	    for (var i = 0, l = this.pattern.firstEditableIndex - this.selection.start; i < l; i++) {
	      if (input.charAt(i) !== this.pattern.pattern[i]) {
	        return false;
	      }
	    } // Continue as if the selection and input started from the editable part of
	    // the pattern.


	    input = input.substring(this.pattern.firstEditableIndex - this.selection.start);
	    this.selection.start = this.pattern.firstEditableIndex;
	  }

	  for (i = 0, l = input.length; i < l && this.selection.start <= this.pattern.lastEditableIndex; i++) {
	    var valid = this.input(input.charAt(i)); // Allow static parts of the pattern to appear in pasted input - they will
	    // already have been stepped over by input(), so verify that the value
	    // deemed invalid by input() was the expected static character.

	    if (!valid) {
	      if (this.selection.start > 0) {
	        // XXX This only allows for one static character to be skipped
	        var patternIndex = this.selection.start - 1;

	        if (!this.pattern.isEditableIndex(patternIndex) && input.charAt(i) === this.pattern.pattern[patternIndex]) {
	          continue;
	        }
	      }

	      extend(this, initialState);
	      return false;
	    }
	  }

	  return true;
	}; // History


	InputMask.prototype.undo = function undo() {
	  // If there is no history, or nothing more on the history stack, we can't undo
	  if (this._history.length === 0 || this._historyIndex === 0) {
	    return false;
	  }

	  var historyItem;

	  if (this._historyIndex == null) {
	    // Not currently undoing, set up the initial history index
	    this._historyIndex = this._history.length - 1;
	    historyItem = this._history[this._historyIndex]; // Add a new history entry if anything has changed since the last one, so we
	    // can redo back to the initial state we started undoing from.

	    var value = this.getValue();

	    if (historyItem.value !== value || historyItem.selection.start !== this.selection.start || historyItem.selection.end !== this.selection.end) {
	      this._history.push({
	        value: value,
	        selection: copy(this.selection),
	        lastOp: this._lastOp,
	        startUndo: true
	      });
	    }
	  } else {
	    historyItem = this._history[--this._historyIndex];
	  }

	  this.value = historyItem.value.split('');
	  this.selection = historyItem.selection;
	  this._lastOp = historyItem.lastOp;
	  return true;
	};

	InputMask.prototype.redo = function redo() {
	  if (this._history.length === 0 || this._historyIndex == null) {
	    return false;
	  }

	  var historyItem = this._history[++this._historyIndex]; // If this is the last history item, we're done redoing

	  if (this._historyIndex === this._history.length - 1) {
	    this._historyIndex = null; // If the last history item was only added to start undoing, remove it

	    if (historyItem.startUndo) {
	      this._history.pop();
	    }
	  }

	  this.value = historyItem.value.split('');
	  this.selection = historyItem.selection;
	  this._lastOp = historyItem.lastOp;
	  return true;
	}; // Getters & setters


	InputMask.prototype.setPattern = function setPattern(pattern, options) {
	  options = extend({
	    selection: {
	      start: 0,
	      end: 0
	    },
	    value: ''
	  }, options);
	  this.pattern = new Pattern(pattern, this.formatCharacters, this.placeholderChar, options.isRevealingMask);
	  this.setValue(options.value);
	  this.emptyValue = this.pattern.formatValue([]).join('');
	  this.selection = options.selection;

	  this._resetHistory();
	};

	InputMask.prototype.setSelection = function setSelection(selection) {
	  this.selection = copy(selection);

	  if (this.selection.start === this.selection.end) {
	    if (this.selection.start < this.pattern.firstEditableIndex) {
	      this.selection.start = this.selection.end = this.pattern.firstEditableIndex;
	      return true;
	    } // Set selection to the first editable, non-placeholder character before the selection
	    // OR to the beginning of the pattern


	    var index = this.selection.start;

	    while (index >= this.pattern.firstEditableIndex) {
	      if (this.pattern.isEditableIndex(index - 1) && this.value[index - 1] !== this.placeholderChar || index === this.pattern.firstEditableIndex) {
	        this.selection.start = this.selection.end = index;
	        break;
	      }

	      index--;
	    }

	    return true;
	  }

	  return false;
	};

	InputMask.prototype.setValue = function setValue(value) {
	  if (value == null) {
	    value = '';
	  }

	  this.value = this.pattern.formatValue(value.split(''));
	};

	InputMask.prototype.getValue = function getValue() {
	  return this.value.join('');
	};

	InputMask.prototype.getRawValue = function getRawValue() {
	  var rawValue = [];

	  for (var i = 0; i < this.value.length; i++) {
	    if (this.pattern._editableIndices[i] === true) {
	      rawValue.push(this.value[i]);
	    }
	  }

	  return rawValue.join('');
	};

	InputMask.prototype._resetHistory = function _resetHistory() {
	  this._history = [];
	  this._historyIndex = null;
	  this._lastOp = null;
	  this._lastSelection = copy(this.selection);
	};

	InputMask.Pattern = Pattern;
	var lib = InputMask;

	// Copy paste from https://gist.github.com/nuxodin/9250e56a3ce6c0446efa
	function ffpoly () {
	  var w = window,
	      d = w.document;

	  if (w.onfocusin === undefined) {
	    d.addEventListener('focus', addPolyfill, true);
	    d.addEventListener('blur', addPolyfill, true);
	    d.addEventListener('focusin', removePolyfill, true);
	    d.addEventListener('focusout', removePolyfill, true);
	  }

	  function addPolyfill(e) {
	    var type = e.type === 'focus' ? 'focusin' : 'focusout';
	    var event = new CustomEvent(type, {
	      bubbles: true,
	      cancelable: false
	    });
	    event.c1Generated = true;
	    e.target.dispatchEvent(event);
	  }

	  function removePolyfill(e) {
	    if (!e.c1Generated) {
	      // focus after focusin, so chrome will the first time trigger tow times focusin
	      d.removeEventListener('focus', addPolyfill, true);
	      d.removeEventListener('blur', addPolyfill, true);
	      d.removeEventListener('focusin', removePolyfill, true);
	      d.removeEventListener('focusout', removePolyfill, true);
	    }

	    setTimeout(function () {
	      d.removeEventListener('focusin', removePolyfill, true);
	      d.removeEventListener('focusout', removePolyfill, true);
	    });
	  }
	}

	function _toConsumableArray(arr) {
	  if (Array.isArray(arr)) {
	    for (var i = 0, arr2 = Array(arr.length); i < arr.length; i++) {
	      arr2[i] = arr[i];
	    }

	    return arr2;
	  } else {
	    return Array.from(arr);
	  }
	}

	ffpoly();
	var MaskedInput = {
	  name: 'MaskedInput',
	  render: function render(h) {
	    return h('input', {
	      ref: 'input',
	      attrs: {
	        disabled: this.maskCore === null || this.disabled
	      },
	      domProps: {
	        value: this.value
	      },
	      on: {
	        keydown: this.keyDown,
	        keypress: this.keyPress,
	        keyup: this.keyUp,
	        textInput: this.textInput,
	        mouseup: this.mouseUp,
	        focusout: this.focusOut,
	        cut: this.cut,
	        copy: this.copy,
	        paste: this.paste
	      }
	    });
	  },
	  data: function data() {
	    return {
	      marginLeft: 0,
	      maskCore: null,
	      updateAfterAll: false
	    };
	  },
	  props: {
	    value: {
	      type: String
	    },
	    mask: {
	      required: true,
	      validator: function validator(value) {
	        return !!(value && value.length >= 1 || value instanceof Object);
	      }
	    },
	    placeholderChar: {
	      type: String,
	      default: '_',
	      validator: function validator(value) {
	        return !!(value && value.length === 1);
	      }
	    },
	    disabled: {
	      type: Boolean,
	      default: false
	    }
	  },
	  watch: {
	    mask: function mask(newValue, oldValue) {
	      if (JSON.stringify(newValue) !== JSON.stringify(oldValue)) {
	        this.initMask();
	      }
	    },
	    value: function value(newValue) {
	      if (this.maskCore) this.maskCore.setValue(newValue); // For multiple inputs support
	    }
	  },
	  mounted: function mounted() {
	    this.initMask();
	  },
	  methods: {
	    initMask: function initMask() {
	      var _this = this;

	      try {
	        if (this.mask instanceof Object) {
	          this.maskCore = new lib(this.mask);
	        } else {
	          this.maskCore = new lib({
	            pattern: this.mask,
	            value: '',
	            placeholderChar: this.placeholderChar,

	            /* eslint-disable quote-props */
	            formatCharacters: {
	              'a': {
	                validate: function validate(char) {
	                  return /^[A-Za-zА-Яа-я]$/.test(char);
	                }
	              },
	              'A': {
	                validate: function validate(char) {
	                  return /^[A-Za-zА-Яа-я]$/.test(char);
	                },
	                transform: function transform(char) {
	                  return char.toUpperCase();
	                }
	              },
	              '*': {
	                validate: function validate(char) {
	                  return /^[\dA-Za-zА-Яа-я]$/.test(char);
	                }
	              },
	              '#': {
	                validate: function validate(char) {
	                  return /^[\dA-Za-zА-Яа-я]$/.test(char);
	                },
	                transform: function transform(char) {
	                  return char.toUpperCase();
	                }
	              },
	              '+': {
	                validate: function validate() {
	                  return true;
	                }
	              }
	            }
	          });
	        }

	        [].concat(_toConsumableArray(this.$refs.input.value)).reduce(function (memo, item) {
	          return _this.maskCore.input(item);
	        }, null);
	        this.maskCore.setSelection({
	          start: 0,
	          end: 0
	        });

	        if (this.$refs.input.value === '') {
	          this.$emit('input', '', '');
	        } else {
	          this.updateToCoreState();
	        }
	      } catch (e) {
	        this.maskCore = null;
	        this.$refs.input.value = 'Error';
	        this.$emit('input', this.$refs.input.value, '');
	      }
	    },
	    getValue: function getValue() {
	      return this.maskCore ? this.maskCore.getValue() : '';
	    },
	    keyDown: function keyDown(e) {
	      // Always
	      if (this.maskCore === null) {
	        e.preventDefault();
	        return;
	      }

	      this.setNativeSelection();

	      switch (e.keyCode) {
	        // backspace
	        case 8:
	          e.preventDefault();

	          if (this.maskCore.selection.start > this.marginLeft || this.maskCore.selection.start !== this.maskCore.selection.end) {
	            this.maskCore.backspace();
	            this.updateToCoreState();
	          }

	          break;
	        // left arrow

	        case 37:
	          e.preventDefault();

	          if (this.$refs.input.selectionStart === this.$refs.input.selectionEnd) {
	            // this.$refs.input.selectionEnd = this.$refs.input.selectionStart - 1; @TODO
	            this.$refs.input.selectionStart -= 1;
	          }

	          this.maskCore.selection = {
	            start: this.$refs.input.selectionStart,
	            end: this.$refs.input.selectionStart
	          };
	          this.updateToCoreState();
	          break;
	        // right arrow

	        case 39:
	          e.preventDefault();

	          if (this.$refs.input.selectionStart === this.$refs.input.selectionEnd) {
	            this.$refs.input.selectionEnd += 1;
	          }

	          this.maskCore.selection = {
	            start: this.$refs.input.selectionEnd,
	            end: this.$refs.input.selectionEnd
	          };
	          this.updateToCoreState();
	          break;
	        // end

	        case 35:
	          e.preventDefault();
	          this.$refs.input.selectionStart = this.$refs.input.value.length;
	          this.$refs.input.selectionEnd = this.$refs.input.value.length;
	          this.maskCore.selection = {
	            start: this.$refs.input.selectionEnd,
	            end: this.$refs.input.selectionEnd
	          };
	          this.updateToCoreState();
	          break;
	        // home

	        case 36:
	          e.preventDefault();
	          this.$refs.input.selectionStart = 0;
	          this.$refs.input.selectionEnd = 0;
	          this.maskCore.selection = {
	            start: this.$refs.input.selectionStart,
	            end: this.$refs.input.selectionStart
	          };
	          this.updateToCoreState();
	          break;
	        // delete

	        case 46:
	          e.preventDefault();

	          if (this.$refs.input.selectionStart === this.$refs.input.selectionEnd) {
	            this.maskCore.setValue('');
	            this.maskCore.setSelection({
	              start: 0,
	              end: 0
	            });
	            this.$refs.input.selectionStart = this.maskCore.selection.start;
	            this.$refs.input.selectionEnd = this.maskCore.selection.start;
	          } else {
	            this.maskCore.backspace();
	          }

	          this.updateToCoreState();
	          break;

	        default:
	          break;
	      }
	    },
	    keyPress: function keyPress(e) {
	      // works only on Desktop
	      if (e.ctrlKey) return; // Fix FF copy/paste issue
	      // IE & FF are not trigger textInput event, so we have to force it

	      /* eslint-disable */

	      var isIE =
	      /*@cc_on!@*/
	      !!document.documentMode; //by http://stackoverflow.com/questions/9847580/how-to-detect-safari-chrome-ie-firefox-and-opera-browser

	      /* eslint-enable */

	      var isFirefox = typeof InstallTrigger !== 'undefined';

	      if (isIE || isFirefox) {
	        e.preventDefault();
	        e.data = e.key;
	        this.textInput(e);
	      }
	    },
	    textInput: function textInput(e) {
	      if (e.preventDefault) e.preventDefault();

	      if (this.maskCore.input(e.data)) {
	        this.updateAfterAll = true;
	      }

	      this.updateToCoreState();
	    },
	    keyUp: function keyUp(e) {
	      if (e.keyCode === 9) {
	        // Preven change selection for Tab in
	        return;
	      }

	      this.updateToCoreState();
	      this.updateAfterAll = false;
	    },
	    cut: function cut(e) {
	      e.preventDefault();

	      if (this.$refs.input.selectionStart !== this.$refs.input.selectionEnd) {
	        try {
	          document.execCommand('copy');
	        } catch (err) {} // eslint-disable-line no-empty


	        this.maskCore.backspace();
	        this.updateToCoreState();
	      }
	    },
	    copy: function copy() {},
	    paste: function paste(e) {
	      var _this2 = this;

	      e.preventDefault();
	      var text = e.clipboardData.getData('text');
	      [].concat(_toConsumableArray(text)).reduce(function (memo, item) {
	        return _this2.maskCore.input(item);
	      }, null);
	      this.updateToCoreState();
	    },
	    updateToCoreState: function updateToCoreState() {
	      if (this.maskCore === null) {
	        return;
	      }

	      if (this.$refs.input.value !== this.maskCore.getValue()) {
	        this.$refs.input.value = this.maskCore.getValue();
	        this.$emit('input', this.$refs.input.value, this.maskCore.getRawValue());
	      }

	      this.$refs.input.selectionStart = this.maskCore.selection.start;
	      this.$refs.input.selectionEnd = this.maskCore.selection.end;
	    },
	    isEmpty: function isEmpty() {
	      if (this.maskCore === null) return true;
	      return this.maskCore.getValue() === this.maskCore.emptyValue;
	    },
	    focusOut: function focusOut() {
	      if (this.isEmpty()) {
	        this.$refs.input.value = '';
	        this.maskCore.setSelection({
	          start: 0,
	          end: 0
	        });
	        this.$emit('input', '', '');
	      }
	    },
	    setNativeSelection: function setNativeSelection() {
	      this.maskCore.selection = {
	        start: this.$refs.input.selectionStart,
	        end: this.$refs.input.selectionEnd
	      };
	    },
	    mouseUp: function mouseUp() {
	      if (this.isEmpty() && this.$refs.input.selectionStart === this.$refs.input.selectionEnd) {
	        this.maskCore.setSelection({
	          start: 0,
	          end: 0
	        });
	        this.$refs.input.selectionStart = this.maskCore.selection.start;
	        this.$refs.input.selectionEnd = this.maskCore.selection.start;
	        this.marginLeft = this.maskCore.selection.start;
	        this.updateToCoreState();
	      } else {
	        this.setNativeSelection();
	      }
	    }
	  }
	};

	var Accordion = ui_vue.Vue.component('Accordion', {
	  name: 'Accordion',
	  template: "\n\t\t<div class=\"as-accordion\">\n\t\t    <slot></slot>\n\t\t</div>\n\t"
	});

	var Accordionitem = ui_vue.Vue.component('Accordionitem', {
	  name: 'Accordionitem',
	  template: "\n\t\t<div \n\t\t\tclass=\"as-accordion__item\" \n\t\t\t:class=\"{ 'as-accordion__item_active': visible, 'as-accordion__item_disabled': !clickable }\"\n\t\t>\n\t\t\t<div \n\t\t\t  class=\"as-accordion__item-trigger\"\n\t\t\t  :class=\"{ 'as-accordion__item-trigger_active': visible }\"\n\t\t\t>\n\t\t\t  <div class=\"as-accordion__item-title-with-btn\">  \n\t\t\t    <div class=\"as-accordion__item-title\"  @click=\"setActiveItem\">{{ title }}</div>\n\t\t\t  </div>\n\t\t\t  <div class=\"as-accordion__item-icon\" :class=\"{ 'as-accordion__item-icon_active': visible }\">\n\t\t\t\t<svg width=\"21\" height=\"22\" viewBox=\"0 0 129 129\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">\n\t\t\t\t  <g opacity=\"1\">\n\t\t\t\t\t<path d=\"m121.3,34.6c-1.6-1.6-4.2-1.6-5.8,0l-51,51.1-51.1-51.1c-1.6-1.6-4.2-1.6-5.8,0-1.6,1.6-1.6,4.2 0,5.8l53.9,53.9c0.8,0.8 1.8,1.2 2.9,1.2 1,0 2.1-0.4 2.9-1.2l53.9-53.9c1.7-1.6 1.7-4.2 0.1-5.8z\" fill=\"#003a7d\"/>\n\t\t\t\t  </g>\n\t\t\t\t</svg>\n\t\t\t  </div>\n\t\t\t</div>\n\t\t\t<transition \n\t\t\t  name=\"as-accordion\" \n\t\t\t  @enter=\"start\" \n\t\t\t  @after-enter=\"end\" \n\t\t\t  @before-leave=\"start\" \n\t\t\t  @after-leave=\"end\"\n\t\t\t>\n\t\t\t  <div class=\"as-accordion__item-wrapper\" v-show=\"visible\">\n\t\t\t\t<div class=\"as-accordion__item-content\">\n\t\t\t\t<slot></slot>\n                </div>\n\t\t\t  </div>\n\t\t\t</transition>\n\t\t\t<div class=\"as-accordion__item-btn-next button--primary\" :class=\"{'disabled': isDisabled}\" v-if=\"visible && showNext\" @click=\"goNext\">\n                 <span class=\"button__text\">\u0414\u0430\u043B\u0435\u0435</span>\n              </div>\n\t\t  </div>\n\t",
	  data: function data() {
	    return {
	      visible: false
	    };
	  },
	  props: {
	    title: {
	      type: String,
	      default: function _default() {
	        return '';
	      }
	    },
	    clickable: {
	      type: Boolean,
	      default: function _default() {
	        return false;
	      }
	    },
	    showNext: {
	      type: Boolean,
	      default: function _default() {
	        return true;
	      }
	    },
	    isVisible: {
	      type: Boolean,
	      default: function _default() {
	        return false;
	      }
	    },
	    internalName: {
	      type: String,
	      default: function _default() {
	        return 'item';
	      }
	    },
	    isDisabled: {
	      type: Boolean,
	      default: function _default() {
	        return false;
	      }
	    }
	  },
	  mounted: function mounted() {
	    this.visible = this.isVisible;
	  },
	  watch: {
	    isVisible: function isVisible(newVal, oldVal) {
	      this.visible = newVal;
	    }
	  },
	  methods: {
	    setActiveItem: function setActiveItem() {
	      if (this.clickable) {
	        this.visible = true;

	        if (this.visible) {
	          this.$emit('select-part', {
	            name: this.internalName
	          });
	        }
	      }
	    },
	    goNext: function goNext() {
	      if (this.clickable) {
	        //this.visible = false;
	        this.$emit('go-next', {
	          name: this.internalName
	        });
	      }
	    },
	    start: function start(el) {
	      el.style.height = "".concat(el.scrollHeight, "px");
	    },
	    end: function end(el) {
	      el.style.height = '';
	    }
	  }
	});

	var Sizes = ui_vue.Vue.component('Sizes', {
	  name: 'Sizes',
	  template: "\n        <div class=\"calculator__result-item calculator__result-item_start calculator__result-item_size d-f-sb f-w\">\n        <div class=\"d-f-sb\" style=\"width: 100%\">\n            <div>\n                <span class=\"d-f\">\n                    <div class=\"calculator__result-item-left\">\n                        <div class=\"calculator__result-subtitle\">\u0428\u0438\u0440\u0438\u043D\u0430</div>\n                        <div class=\"calculator__result-item-text\">\u043E\u0442 {{ minWidth }} \u0434\u043E {{ maxWidth }} \u043C\u043C</div>\n                    </div>\n                    <input \n                        type=\"text\" \n                        v-model=\"innerWidth\"\n                        :min=\"minWidth\"\n                        :max=\"maxWidth\"\n                        class=\"calculator__result-size-value d-f-c-c\"\n                        @input=\"$emit('set-size', {type: 'width', value: innerWidth})\"\n                    >\n                </span>\n                <span class=\"calculator__validator\"> {{ widthError }} </span>\n<!--                <span class=\"calculator__validator\">{{validation.firstError('selected.width')}}</span>-->\n            </div>\n            <div>\n                <span class=\"d-f\">\n                    <div class=\"calculator__result-item-left\">\n                        <div class=\"calculator__result-subtitle\">\u0412\u044B\u0441\u043E\u0442\u0430</div>\n                        <div class=\"calculator__result-item-text\">\u043E\u0442 {{ minHeight }} \u0434\u043E {{ maxHeight }} \u043C\u043C</div>\n                    </div>\n                    <input \n                        type=\"text\" \n                        v-model=\"innerHeight\"\n                        :min=\"minHeight\"\n                        :max=\"maxHeight\"\n                        class=\"calculator__result-size-value d-f-c-c\"\n                        @input=\"$emit('set-size', {type: 'height', value: innerHeight})\"\n                    >\n                </span>\n                <span class=\"calculator__validator\"> {{ heightError }} </span>\n<!--                <span class=\"calculator__validator\">{{validation.firstError('selected.height')}}</span>-->\n            </div>\n            \n            <div v-if=\"availableSizes && availableSizes.length > 0\">\n             <span class=\"d-f\">\n                    <div class=\"as-accordion__item-btn-sizes button--primary\" @click=\"showAvailable = !showAvailable\">\n                        <span class=\"button__text\" style=\"padding: 11px 15px\">&#9776;</span>\n                    </div>\n                    \n                    <ul class=\"gate-size-select__popup\" v-if=\"showAvailable\">\n                        <li class=\"gate-size-select__popup_item\" v-for=\"availableSize in availableSizes\" :key=\"availableSize\" @click=\"setPreDefinedSizes(availableSize)\">\n                            {{ availableSize }}\n                        </li>\n                    </ul>\n                    </span>\n            </div>\n            </div>\n        </div>\n\t",
	  data: function data() {
	    return {
	      innerWidth: '',
	      innerHeight: '',
	      showAvailable: false
	    };
	  },
	  mounted: function mounted() {
	    this.innerWidth = this.width;
	    this.innerHeight = this.height;
	  },
	  props: ['height', 'width', 'maxHeight', 'minHeight', 'maxWidth', 'minWidth', 'heightError', 'widthError', 'availableSizes'],
	  methods: {
	    setPreDefinedSizes: function setPreDefinedSizes(size) {
	      size = size.split(' x ');
	      this.innerWidth = +size[0];
	      this.innerHeight = +size[1];
	      this.$emit('set-size', {
	        type: 'width',
	        value: this.innerWidth
	      });
	      this.$emit('set-size', {
	        type: 'height',
	        value: this.innerHeight
	      });
	      this.showAvailable = false;
	    }
	  },
	  watch: {
	    innerHeight: function innerHeight(newVal, oldVal) {
	      if (newVal) {
	        this.innerHeight = newVal.replace(/\D/g, '');
	        this.$emit('set-size', {
	          type: 'height',
	          value: this.innerHeight
	        });
	      }
	    },
	    innerWidth: function innerWidth(newVal, oldVal) {
	      if (newVal) {
	        this.innerWidth = newVal.replace(/\D/g, '');
	        this.$emit('set-size', {
	          type: 'width',
	          value: this.innerWidth
	        });
	      }
	    }
	  }
	});

	var Baseas = ui_vue.Vue.component('Baseas', {
	  name: 'Baseas',
	  template: "\n        <div class=\"calculator__result-item calculator__result-item_motive\">\n            <div class=\"d-f f-w\">\n                <label v-for=\"bas in baseData\" :key=\"bas.id\" v-if=\"bas.available === true || bas.available === undefined\" \n                :class=\"{'selected': base == bas.id}\" style=\"margin-right: 20px\">\n                    <span class=\"calculator__result-item-img\">\n                        <img :src=\"bas.img || '/static/src/images/calculator/test.png'\" alt=\"\">\n                    </span>\n                    <span class=\"calculator__result-item-name\">{{ bas.name }}</span>\n                    <span v-if=\"bas.available !== undefined && bas.available !== true\" class=\"calculator__unvailable\">\u041D\u0435\u0434\u043E\u0441\u0442\u0443\u043F\u043D\u043E</span>\n                    <input\n                            type=\"radio\"\n                            :disabled=\"bas.available !== undefined && bas.available !== true\"\n                            @change=\"$emit('recalculate', { 'name': 'base', 'selected': base })\"\n                            :value=\"bas.id\"\n                            v-model=\"base\"\n                    >\n                </label>\n            </div>\n        </div>\n\t",
	  data: function data() {
	    return {
	      base: null
	    };
	  },
	  props: {
	    baseData: {
	      type: Array,
	      default: function _default() {
	        return [];
	      }
	    }
	  }
	});

	var Coloras = ui_vue.Vue.component('Coloras', {
	  name: 'Coloras',
	  template: "\n        <div class=\"calculator__result-item calculator__result-item_start calculator__result-item-color\">\n            <div class=\"calculator__row d-f-sb\">\n                <div class=\"calculator__col\">\n                    <div class=\"calculator__result-subtitle\">\u0421\u0442\u0430\u043D\u0434\u0430\u0440\u0442\u043D\u044B\u0435 \u0446\u0432\u0435\u0442\u0430</div>\n<!--                    <div class=\"calculator__result-item-name\" style=\"margin-bottom: 8px\">-->\n<!--                        {{ selectedColor }}-->\n<!--                    </div>--> \n                    <div class=\"calculator__row d-f f-w\">\n                        <label\n                                v-for=\"col in colorData\"\n                                :key=\"col.id\"\n                                v-if=\"col.available === true || col.available === undefined\"\n                                :style=\"{backgroundImage: 'url('+col.img+')'}\"\n                                class=\"calculator__col calculator__col-color d-f-c-c\"\n                        >\n                            <input\n                                    type=\"radio\"\n                                    :disabled=\"col.available !== true && col.available !== undefined\"\n                                    v-model=\"colorId\"\n                                    @change=\"selected(colorId)\"\n                                    :value=\"col.id\"\n                            >\n                            <span style=\"border: 1px solid #003a7d\"></span>\n                        </label>\n                    </div>\n                </div>\n                \n                <div class=\"calculator__col\" v-if=\"false\">\n                    <div class=\"calculator__result-subtitle\">\u0414\u043E\u043F\u043E\u043B\u043D\u0438\u0442\u0435\u043B\u044C\u043D\u044B\u0435 +1872 \u20BD</div>\n                    <div class=\"calculator__result-item-name\" style=\"margin-bottom: 8px\">\n                        {{ selectedColor }}\n                    </div>\n                    <div class=\"calculator__row d-f f-w\">\n                        <label\n                                v-for=\"col in colorData\"\n                                :key=\"col.id\"\n                                v-if=\"col.available\"\n                                :style=\"{backgroundImage: 'url('+col.img+')'}\"\n                                class=\"calculator__col calculator__col-color d-f-c-c\"\n                        >\n                            <input\n                                    type=\"radio\"\n                                    :disabled=\"!col.available\"\n                                    v-model=\"colorId\"\n                                    @change=\"selected(colorId)\"\n                                    :value=\"col.id\"\n                            >\n                            <span style=\"border: 1px solid #003a7d\"></span>\n                        </label>\n                    </div>\n                </div>\n            </div>\n        </div>\n\t",
	  data: function data() {
	    return {
	      colorId: null,
	      selectedColor: ''
	    };
	  },
	  props: {
	    colorData: {
	      type: Array,
	      default: function _default() {
	        return [];
	      }
	    }
	  },
	  methods: {
	    selected: function selected(id) {
	      this.selectedColor = this.colorData.find(function (el) {
	        return el.id === id;
	      }).name;
	      this.$emit('recalculate', {
	        'name': 'color',
	        'selected': id
	      });
	    }
	  }
	});

	var Surfaceas = ui_vue.Vue.component('Surfaceas', {
	  name: 'Surfaceas',
	  template: "\n        <div class=\"calculator__result-item calculator__result-item-surface\">\n            <div class=\"d-f f-w\">\n                <label v-for=\"surfac in surfaceData\" :key=\"surfac.id\" :class=\"{'selected': surfaceId == surfac.id}\" v-if=\"surfac.available === true || surfac.available === undefined\">\n                   <span class=\"calculator__result-item-img\">\n                        <img \n                            :src=\"surfac.img || '/static/src/images/calculator/test.png'\" \n                            alt=\"\" \n                            class=\"calculator__result-item-img\"\n                        >\n                    </span>\n                    <div class=\"calculator__result-item-name\" style=\"display: flex;align-items: center;\">{{ surfac.name }} <span style=\"display: inline;margin-left: 5px;\" :data-hint=\"surfac.description\"></span></div>\n                    <input \n                        type=\"radio\" \n                        v-model=\"surfaceId\"\n                        @change=\"selected(surfaceId)\"\n                        :value=\"surfac.id\"\n                    >\n                </label>\n            </div>\n        </div>\n    ",
	  data: function data() {
	    return {
	      surfaceId: null,
	      selectedSurface: ''
	    };
	  },
	  props: {
	    surfaceData: {
	      type: Array,
	      default: function _default() {
	        return [];
	      }
	    }
	  },
	  methods: {
	    selected: function selected(id) {
	      this.selectedSurface = this.surfaceData.find(function (el) {
	        return el.id === id;
	      }).name;
	      this.$emit('recalculate', {
	        'name': 'surface',
	        'selected': id
	      });
	    }
	  }
	});

	var Driveas = ui_vue.Vue.component('Driveas', {
	  name: 'Driveas',
	  template: "\n        <div class=\"calculator__result-item calculator__result-item_start calculator__result-item-drive\">\n            <div class=\"d-f f-w\">\n                <div class=\"calculator__result-tabs\">\n<!--                    <div class=\"calculator__result-tabs-titles d-f\">-->\n<!--                        <div-->\n<!--                                class=\"calculator__result-tabs-title\"-->\n<!--                                :class=\"{ 'calculator__result-tabs-title_active': driveTab === 'auto' }\"-->\n<!--                                @click=\"driveTab = 'auto'\"-->\n<!--                        >-->\n<!--                            \u0410\u0432\u0442\u043E\u043C\u0430\u0442\u0438\u0447\u0435\u0441\u043A\u0438\u0435-->\n<!--                        </div>-->\n<!--                        <div-->\n<!--                                class=\"calculator__result-tabs-title\"-->\n<!--                                :class=\"{ 'calculator__result-tabs-title_active': driveTab === 'hand' }\"-->\n<!--                                @click=\"driveTab = 'hand'\"-->\n<!--                        >-->\n<!--                            \u0420\u0443\u0447\u043D\u043E\u0435 \u0443\u043F\u0440\u0430\u0432\u043B\u0435\u043D\u0438\u0435-->\n<!--                        </div>-->\n<!--                    </div>-->\n                    <div class=\"calculator__result-tabs-content\">\n                        <div class=\"calculator__result-tabs-content-item d-f\" v-if=\"driveTab === 'auto'\">\n                        <div class=\"calculator__result-tabs-col\"  v-if=\"false\">\n                        <div>\n                            <div class=\"calculator__result-tabs-col-item calculator__result-tabs-col-item_photo\"></div>\n                            <div class=\"calculator__result-item-content\">\n                                <div class=\"calculator__result-tabs-col-item calculator__result-tabs-col-item_name correct\"></div>\n                                <div class=\"calculator__result-tabs-col-item calculator__result-tabs-col-item_price correct\"></div>\n                                <div class=\"calculator__result-tabs-col-item correct\">\u0426\u0438\u043A\u043B\u044B \u0432 \u0434\u0435\u043D\u044C/\u0447\u0430\u0441</div>\n                                <div class=\"calculator__result-tabs-col-item correct\">\u041F\u0438\u043A\u043E\u0432\u043E\u0435 \u0443\u0441\u0438\u043B\u0438\u0435</div>\n                                <div class=\"calculator__result-tabs-col-item correct\">\u0421\u043A\u043E\u0440\u043E\u0441\u0442\u044C, \u043C\u0430\u043A\u0441.</div>\n                                <div class=\"calculator__result-tabs-col-item correct \">\u0428\u0438\u0440\u0438\u043D\u0430, \u043C\u0430\u043A\u0441.</div>\n                                <div class=\"calculator__result-tabs-col-item correct\">\u041F\u043B\u043E\u0449\u0430\u0434\u044C</div>\n                                <div class=\"calculator__result-tabs-col-item correct\">\u0421\u0435\u0440. \u043E\u0441\u043D\u0430\u0449\u0435\u043D\u0438\u0435</div>\n                            </div>\n                            </div>\n                        </div>\n                        <div class=\"calculator__result-tabs-col\" :class=\"{'selected': driveId == 5}\">\n                            <label>\n                                <span class=\"calculator__result-item-img\">\n                                    <img class=\" calculator__result-tabs-col-item_photo calculator__result-tabs-col-item\"\n                                        :src=\"'/upload/uf/5fc/6azxb2f2w82vaebd5zm4y6tw3ugfbbgg.jpg'\"\n                                        alt=\"\"\n                                    >\n                                </span>\n                                <span class=\"calculator__result-item-content\"> \n                                    <div class=\"calculator__result-item-name calculator__result-tabs-col-item\">\u0411\u0435\u0437 \u043F\u0440\u0438\u0432\u043E\u0434\u0430</div>\n                                   \n                                    <input \n                                        type=\"radio\" \n                                        v-model=\"driveId\"\n                                        @change=\"selected(5)\"\n                                        :value=\"5\"\n                                    >\n                                   \n                                </span>\n                            </label>\n                        </div>\n                        <div class=\"calculator__result-tabs-col\" v-for=\"dr in driveData\" :class=\"{'selected': driveId == dr.id}\" :key=\"dr.id\" v-if=\"dr.name && dr.available\">\n                            <label>\n                                <span class=\"calculator__result-item-img\">\n                                    <img class=\" calculator__result-tabs-col-item_photo calculator__result-tabs-col-item\"\n                                        :src=\"dr.img || '/static/src/images/calculator/test.png'\"\n                                        alt=\"\"\n                                    >\n                                    <span v-if=\"!dr.available\" class=\"calculator__unvailable\">\u041D\u0435\u0434\u043E\u0441\u0442\u0443\u043F\u043D\u043E</span>\n                                </span>\n                                <span class=\"calculator__result-item-content\"> \n                                    <div class=\"calculator__result-item-name calculator__result-tabs-col-item\">{{ dr.name }}</div>\n                                    <span class=\"calculator__result-item-price calculator__result-tabs-col-item\" v-if=\"dr.price\">{{ dr.formattedPrice }}</span>\n                                    <input \n                                        type=\"radio\" \n                                        v-model=\"driveId\"\n                                        @change=\"selected(driveId)\"\n                                        :disabled=\"!dr.available\"\n                                        :value=\"dr.id\"\n                                    >\n                                    <div v-if=\"false\">\n                                    <span class=\"calculator__result-tabs-col-item\">25/10</span>\n                                    <span class=\"calculator__result-tabs-col-item\">800 H</span>\n                                    <span class=\"calculator__result-tabs-col-item\">22 \u0441\u043C/\u0441</span>\n                                    <span class=\"calculator__result-tabs-col-item\">5500 \u043C\u043C</span>\n                                    <span class=\"calculator__result-tabs-col-item\">13,75 \u043C\xB3</span>\n                                    <span class=\"calculator__result-item-description\">\n                                        {{ dr.description || '\u0417\u0430\u043F\u0440\u043E\u0441 \u043F\u043E\u043B\u043E\u0436\u0435\u043D\u0438\u044F; \u0431\u044B\u0441\u0442\u0440\u043E\u0435 \u043E\u0442\u043A\u0440\u044B\u0432\u0430\u043D\u0438\u0435 \u0434\u0432\u0435\u0440\u0438; \u0434\u043E\u043F\u043E\u043B\u043D\u0438\u0442\u0435\u043B\u044C\u043D\u0430\u044F. \u0432\u044B\u0441\u043E\u0442\u0430 \u043E\u0442\u043A\u0440\u044B\u0432\u0430\u043D\u0438\u044F; \u043E\u0442\u0434\u0435\u043B\u044C\u043D\u043E \u0432\u043A\u043B\u044E\u0447. \u0433\u0430\u043B\u043E\u0433\u0435\u043D\u043D\u043E\u0435 \u043E\u0441\u0432\u0435\u0449.; \u043E\u0442\u0434\u0435\u043B\u044C\u043D\u043E \u0432\u043A\u043B\u044E\u0447. \u0441\u0432\u0435\u0442\u043E\u0434\u0438\u043E\u0434\u043D\u043E\u0435 \u043E\u0441\u0432\u0435\u0449\u0435\u043D\u0438\u0435 (\u0441 \u043C\u0430\u0440\u0442\u0430 2017); \u043F\u0440\u043E\u0441\u0442\u043E\u0435 \u043F\u0440\u043E\u0433\u0440\u0430\u043C\u043C\u0438\u0440\u043E\u0432\u0430\u043D\u0438\u0435; \u0437\u0430\u0449\u0438\u0442\u0430 \u043E\u0442 \u043F\u043E\u0434\u0432\u0430\u0436\u0438\u0432\u0430\u043D\u0438\u044F; \u0441\u0438\u0441\u0442\u0435\u043C\u0430 \u0414\u0423 BiSecure' }}\n                                    </span>\n                                    </div>\n                                </span>\n                            </label>\n                        </div>\n                        </div>\n                        <div class=\"calculator__result-tabs-content-item d-f\" v-if=\"driveTab === 'hand'\">\n                            <label>\n                                <div class=\"calculator__result-item-name\">\u0417\u0434\u0435\u0441\u044C \u043F\u043E\u043A\u0430 \u043D\u0435\u0442 \u0438\u043D\u0444\u043E\u0440\u043C\u0430\u0446\u0438\u0438</div>\n                            </label>\n                        </div>\n                    </div>\n                </div>\n            </div>\n        </div>\n    ",
	  data: function data() {
	    return {
	      driveId: null,
	      selectedDrive: '',
	      driveTab: 'auto'
	    };
	  },
	  props: {
	    driveData: {
	      type: Array,
	      default: function _default() {
	        return [];
	      }
	    }
	  },
	  methods: {
	    selected: function selected(id) {
	      if (id == 5) {
	        this.selectedDrive = 'Без привода';
	      } else {
	        this.selectedDrive = this.driveData.find(function (el) {
	          return el.id === id;
	        }).name;
	      }

	      this.$emit('recalculate', {
	        'name': 'drive',
	        'selected': id
	      });
	    }
	  }
	});

	var Faceas = ui_vue.Vue.component('Faceas', {
	  name: 'Faceas',
	  template: "\n        <div class=\"calculator__result-item calculator__result-item-face\">\n            <div class=\"d-f f-w\">\n                <label v-for=\"face in faceData\" :key=\"face.id\" v-if=\"face.available === true || face.available === undefined\"\n                :class=\"{'selected': faseId == face.id}\">\n                    <span class=\"calculator__result-item-img\">\n                        <img :src=\"face.img || '/static/src/images/calculator/test.png'\" alt=\"\">\n                    </span>\n                    <div class=\"calculator__result-item-name\">{{ face.name }}</div>\n                    <span v-if=\"face.available !== true && face.available !== undefined\" class=\"calculator__unvailable\">\u041D\u0435\u0434\u043E\u0441\u0442\u0443\u043F\u043D\u043E</span>\n                    <input\n                        type=\"radio\"\n                        :disabled=\"face.available !== true && face.available !== undefined\"\n                        v-model=\"faseId\"\n                        @change=\"selected(faseId)\"\n                        :value=\"face.id\"\n                    >\n                </label>\n            </div>\n        </div>\n    ",
	  data: function data() {
	    return {
	      faseId: null,
	      selectedFace: ''
	    };
	  },
	  props: {
	    faceData: {
	      type: Array,
	      default: function _default() {
	        return [];
	      }
	    }
	  },
	  methods: {
	    selected: function selected(id) {
	      this.selectedFace = this.faceData.find(function (el) {
	        return el.id === id;
	      }).name;
	      this.$emit('recalculate', {
	        'name': 'face',
	        'selected': id
	      });
	    }
	  }
	});

	var Glassas = ui_vue.Vue.component('Glassas', {
	  name: 'Glassas',
	  template: "\n        <div class=\"calculator__result-item calculator__result-item_glass\">\n            <div class=\"d-f f-w\">\n                <label\n                        v-for=\"gl in glassData\"\n                        :key=\"gl.id\"\n                        v-if=\"gl.name && (gl.available === true || gl.available === undefined)\"\n                        :class=\"{'selected': glId == gl.id}\"\n                >\n                    <span class=\"calculator__result-item-img\">\n                        <img :src=\"gl.img\" alt=\"\">\n                    </span>\n                    <div class=\"calculator__result-item-name\">{{ gl.name }}</div>\n                    <span v-if=\"gl.available !== true && gl.available !== undefined\" class=\"calculator__unvailable\">\u041D\u0435\u0434\u043E\u0441\u0442\u0443\u043F\u043D\u043E</span>\n                    <input\n                        type=\"radio\" \n                        v-model=\"glId\"\n                        @change=\"selected(glId)\"\n                        :value=\"gl.id\"\n                    >\n                </label>\n            </div>\n        </div>\n    ",
	  data: function data() {
	    return {
	      glId: null,
	      selectedGl: ''
	    };
	  },
	  props: {
	    glassData: {
	      type: Array,
	      default: function _default() {
	        return [];
	      }
	    }
	  },
	  methods: {
	    selected: function selected(id) {
	      this.selectedGl = this.glassData.find(function (el) {
	        return el.id === id;
	      }).name;
	      this.$emit('recalculate', {
	        'name': 'glass',
	        'selected': id
	      });
	    }
	  }
	});

	function _createForOfIteratorHelper(o, allowArrayLike) { var it; if (typeof Symbol === "undefined" || o[Symbol.iterator] == null) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = o[Symbol.iterator](); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it.return != null) it.return(); } finally { if (didErr) throw err; } } }; }

	function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

	function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }
	var Calculator = /*#__PURE__*/function () {
	  function Calculator() {
	    var options = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {
	      el: "",
	      params: {}
	    };
	    babelHelpers.classCallCheck(this, Calculator);
	    this.params = options.params;
	    if (options.el) this.vueComponent = this.createVueComponent(options.el);
	  }

	  babelHelpers.createClass(Calculator, [{
	    key: "createVueComponent",
	    value: function createVueComponent(el) {
	      var Validator = src.Validator;
	      this.vueComponent = ui_vue.Vue.create({
	        el: el,
	        components: {
	          MaskedInput: MaskedInput
	        },
	        data: function data() {
	          var _this = this;

	          return {
	            sTemplate: null,
	            sParams: null,
	            action: null,
	            loading: false,
	            timer: null,
	            defaultPhoto: '/static/src/images/calculator/templates-1.png',
	            mainImg: "/static/src/images/calculator/templates-1.png",
	            photo: null,
	            surface: [],
	            base: [],
	            sizes: [],
	            def_color: [],
	            rec_colors: [],
	            glass: [],
	            gateTypes: [],
	            facings: [],
	            drive: [],
	            maxWidth: null,
	            maxHeight: null,
	            minWidth: null,
	            minHeight: null,
	            total: null,
	            descriptions: null,
	            name: null,
	            lastName: null,
	            email: null,
	            phone: null,
	            city: null,
	            comment: null,
	            success: false,
	            successMsg: '',
	            submitted: null,
	            selectedPart: "size",
	            visited: ['size'],
	            isFinal: false,
	            isEnd: false,
	            parts: [{
	              key: "gateSize",
	              value: "Размеры ворот",
	              selected: "",
	              available: false,
	              modal: "gateSizeModalText",
	              internalName: 'size',
	              validateFunction: function validateFunction() {
	                return _this.selected.width >= _this.minWidth && _this.selected.width <= _this.maxWidth && _this.selected.height >= _this.minHeight && _this.selected.height <= _this.maxHeight;
	              },
	              showError: false,
	              errorMessage: 'Введите размеры ворот'
	            }, {
	              key: "surface",
	              value: "Поверхность",
	              selected: "",
	              available: false,
	              modal: "surfaceModalText",
	              internalName: 'surface',
	              validateFunction: function validateFunction() {
	                return _this.selected.surface != null && _this.selected.surface != undefined;
	              },
	              showError: false,
	              errorMessage: 'Выберите тип поверхности'
	            }, {
	              key: "base",
	              value: "Мотив",
	              selected: "",
	              available: false,
	              modal: "baseModalText",
	              internalName: 'base',
	              validateFunction: function validateFunction() {
	                return _this.selected.base != null && _this.selected.base != undefined;
	              },
	              showError: false,
	              errorMessage: 'Выберите мотив'
	            }, {
	              key: "color",
	              value: "Цвет",
	              selected: "",
	              available: false,
	              modal: "colorModalText",
	              internalName: "color",
	              validateFunction: function validateFunction() {
	                return _this.selected.color != null && _this.selected.color != undefined;
	              },
	              showError: false,
	              errorMessage: 'Выберите цвет'
	            }, {
	              key: "drive",
	              value: "Управление",
	              selected: "",
	              available: false,
	              modal: "driveModalText",
	              internalName: "drive"
	            }, {
	              key: "face",
	              value: "Отделка",
	              selected: "",
	              available: false,
	              modal: "faceModalText",
	              internalName: "facing",

	              /* validateFunction: () => {
	                  return this.selected.face != null && this.selected.face != undefined;
	              }, */
	              showError: false,
	              errorMessage: 'Выберите дизайн'
	            }, {
	              key: "glass",
	              value: "Остекление",
	              selected: "",
	              available: false,
	              modal: "glassModalText",
	              internalName: "glass",

	              /* validateFunction: () => {
	                  return this.selected.glass != null && this.selected.glass != undefined;
	              }, */
	              showError: false,
	              errorMessage: 'Выберите тип остекления'
	            }],
	            activePart: "",
	            currentModalText: "",
	            driveTab: "auto",
	            selected: {
	              gateType: 1,
	              surface: null,
	              base: null,
	              face: null,
	              drive: 5,
	              color: null,
	              glass: null,
	              width: null,
	              height: null,
	              size: null
	            }
	          };
	        },
	        props: [],
	        computed: {
	          selectedGateTypeName: function selectedGateTypeName() {
	            if (this.selected.gateType) {
	              var _iterator = _createForOfIteratorHelper(this.gateTypes),
	                  _step;

	              try {
	                for (_iterator.s(); !(_step = _iterator.n()).done;) {
	                  var gateType = _step.value;

	                  if (gateType.ID == this.selected.gateType) {
	                    return gateType.UF_NAME;
	                  }
	                }
	              } catch (err) {
	                _iterator.e(err);
	              } finally {
	                _iterator.f();
	              }
	            }

	            return "";
	          },
	          error: function error() {
	            if (this.selected && this.selected.base && this.selected.face) {
	              var _iterator2 = _createForOfIteratorHelper(this.base),
	                  _step2;

	              try {
	                for (_iterator2.s(); !(_step2 = _iterator2.n()).done;) {
	                  var baseElement = _step2.value;

	                  if (baseElement.id == this.selected.base && baseElement.available === false) {
	                    return "Недоступно с выбранными параметрами";
	                  }
	                }
	              } catch (err) {
	                _iterator2.e(err);
	              } finally {
	                _iterator2.f();
	              }
	            }

	            return "";
	          },
	          error2: function error2() {
	            if (this.selected && this.selected.surface && this.selected.face) {
	              var _iterator3 = _createForOfIteratorHelper(this.surface),
	                  _step3;

	              try {
	                for (_iterator3.s(); !(_step3 = _iterator3.n()).done;) {
	                  var baseElement = _step3.value;

	                  if (baseElement.id == this.selected.surface && baseElement.available === false) {
	                    return "Недоступно с выбранными параметрами";
	                  }
	                }
	              } catch (err) {
	                _iterator3.e(err);
	              } finally {
	                _iterator3.f();
	              }
	            }

	            return "";
	          }
	        },
	        watch: {
	          "selected.gateType": function selectedGateType(newValue, oldValue) {
	            if (newValue != null) {
	              this.getAvailableParams(newValue);
	            }
	          },
	          "selected.width": function selectedWidth(newValue, oldValue) {
	            if (newValue != oldValue && newValue != null) {
	              this.getDrives();
	            }
	          },
	          "selected.height": function selectedHeight(newValue, oldValue) {
	            if (newValue != oldValue && newValue != null) {
	              this.getDrives();
	            }
	          }
	        },
	        methods: {
	          isPartClickable: function isPartClickable(partName) {
	            return this.visited.includes(partName);
	          },
	          onPartSelect: function onPartSelect(arg) {
	            this.setSelectedPart(arg['name']);
	          },
	          onGoNext: function onGoNext(arg) {
	            var next = this.getNextPartName(arg['name']);

	            if (next) {
	              this.isFinal = false;
	              var currentPart = this.getCurrentPart();

	              if (currentPart.validateFunction != null && currentPart.validateFunction != undefined) {
	                if (currentPart.validateFunction()) {
	                  currentPart.showError = false;
	                  this.visited.push(next);
	                  this.setSelectedPart(next);
	                } else {
	                  currentPart.showError = true;
	                }
	              } else {
	                this.visited.push(next);
	                this.setSelectedPart(next);
	                currentPart.showError = false;
	              }
	            } else {
	              this.isFinal = true;
	              this.isEnd = true;
	            }
	          },
	          setSelectedPart: function setSelectedPart(partName) {
	            this.selectedPart = partName;
	          },
	          getNextPartName: function getNextPartName(partName) {
	            var partNameIndex = -1;

	            for (var i = 0; i < this.parts.length; i++) {
	              if (this.parts[i].internalName === partName) {
	                partNameIndex = i;
	              }
	            }

	            if (partNameIndex === this.parts.length - 1) {
	              return null;
	            } else {
	              var before = partNameIndex;

	              for (var _i = partNameIndex + 1; _i < this.parts.length; _i++) {
	                var partInternalName = this.parts[_i].internalName;
	                var name$$1 = '';

	                switch (partInternalName) {
	                  case 'surface':
	                    name$$1 = 'surface';
	                    break;

	                  case 'base':
	                    name$$1 = 'base';
	                    break;

	                  case 'color':
	                    name$$1 = 'rec_colors';
	                    break;

	                  case 'drive':
	                    name$$1 = 'drive';
	                    break;

	                  case 'facing':
	                    name$$1 = 'facings';
	                    break;

	                  case 'glass':
	                    name$$1 = 'glass';
	                    break;
	                }

	                if (name$$1 && this.isPartAvailable(name$$1)) {
	                  partNameIndex = _i;
	                  break;
	                }
	              }

	              if (before === partNameIndex) {
	                partNameIndex = 0;
	                return null;
	              }
	            }

	            return this.parts[partNameIndex].internalName;
	          },
	          getCurrentPart: function getCurrentPart() {
	            var _iterator4 = _createForOfIteratorHelper(this.parts),
	                _step4;

	            try {
	              for (_iterator4.s(); !(_step4 = _iterator4.n()).done;) {
	                var part = _step4.value;

	                if (part.internalName == this.selectedPart) {
	                  return part;
	                }
	              }
	            } catch (err) {
	              _iterator4.e(err);
	            } finally {
	              _iterator4.f();
	            }

	            return null;
	          },
	          setCurrentModalText: function setCurrentModalText(e) {
	            console.log(e);
	            var part = e.target.getAttribute("data-part");
	            var partElement = this.parts.filter(function (el) {
	              return el.key === part;
	            });

	            if (this.descriptions && this.descriptions[part]) {
	              this.currentModalText = this.descriptions[part];
	              $.fancybox.open(e.target);
	            }
	          },
	          isPartAvailable: function isPartAvailable(partName) {
	            var _iterator5 = _createForOfIteratorHelper(this[partName]),
	                _step5;

	            try {
	              for (_iterator5.s(); !(_step5 = _iterator5.n()).done;) {
	                var item = _step5.value;

	                if (partName != 'drive') {
	                  if (item.available === null || item.available === undefined) {
	                    return true;
	                  }
	                }

	                if (item.available === true && item.id) {
	                  return true;
	                }
	              }
	            } catch (err) {
	              _iterator5.e(err);
	            } finally {
	              _iterator5.f();
	            }

	            return false;
	          },
	          setAjaxParams: function setAjaxParams(params) {
	            this.sTemplate = params.sTemplate;
	            this.sParams = params.sParams;
	            this.action = params.action;
	          },
	          setData: function setData(params) {
	            if (params.gateTypes) {
	              this.gateTypes = params.gateTypes;
	            }

	            if (params.type) {
	              this.selected.gateType = params.type;
	            }

	            if (params.descriptions) {
	              this.descriptions = params.descriptions;
	            }

	            if (params.city) {
	              this.city = params.city;
	            }
	          },
	          getSelectedValue: function getSelectedValue(name$$1) {
	            var id = this.selected[name$$1];

	            if (name$$1 === "color") {
	              id = this.selected[name$$1];
	              name$$1 = "rec_colors";
	            }

	            if (name$$1 === "face") {
	              name$$1 = "facings";
	            }

	            if (name$$1 === "size") {
	              this.parts[0].selected = "".concat(this.selected.width, " x ").concat(this.selected.height);
	              return;
	            }

	            if (name$$1 === "drive" && this.selected.drive == 5) {
	              var _obj = this.parts.find(function (el) {
	                return el.key === 'drive';
	              });

	              _obj.selected = 'Без привода';
	              return;
	            }

	            var arr = this[name$$1];
	            var value = arr.find(function (el) {
	              return el.id === id;
	            }).name;
	            var obj = this.parts.find(function (el) {
	              return el.key === (name$$1 === "rec_colors" ? "color" : name$$1 === "facings" ? "face" : name$$1);
	            });
	            obj.selected = value || "";
	          },
	          recalculate: function recalculate(name$$1) {
	            this.getSelectedValue(name$$1);
	            var data = this.selected;
	            data["action"] = "recalculate"; // Если заполнены параметры по которым идет расчет цены
	            // то рапрашиваем цены

	            if (this.selected.base && this.selected.surface && this.selected.width && this.selected.height) {
	              data["showPrice"] = true;
	            }

	            this.sendRequest(this.selected);
	          },
	          getAvailableParams: function getAvailableParams(gateType) {
	            var data = {
	              gateType: gateType,
	              action: "init"
	            };
	            this.sendRequest(data);
	            this.selected = {
	              gateType: gateType,
	              surface: null,
	              base: null,
	              face: null,
	              drive: 5,
	              color: null,
	              glass: null,
	              width: null,
	              height: null,
	              size: null
	            };

	            for (var i = 0; i < this.parts.length; i++) {
	              //this.parts[i].available = false;
	              this.parts[i].selected = null;
	            }

	            this.selectedPart = 'size';
	            this.visited = ['size'];
	            this.isEnd = false;
	          },
	          getDrives: function getDrives() {
	            var _this2 = this;

	            this.$validate().then(function (success) {
	              if (success) {
	                if (_this2.selected.width && _this2.selected.height && !_this2.timer) {
	                  _this2.timer = setTimeout(function () {
	                    _this2.recalculate("size");

	                    _this2.timer = null;
	                  }, 500);
	                }
	              } else {
	                _this2.drive = [];
	                _this2.parts[4].available = false;
	              }
	            });
	          },
	          createOrder: function createOrder() {
	            var _this3 = this;

	            var data = this.selected;
	            data["action"] = "createOrder";
	            this.submitted = true;
	            this.$validate().then(function (success) {
	              data['name'] = _this3.name;
	              data['lastName'] = _this3.lastName;
	              data['comment'] = _this3.comment;
	              data['phone'] = _this3.phone;
	              data['email'] = _this3.email;
	              data['city'] = _this3.city;

	              if (success) {
	                _this3.sendRequest(data);
	              }
	            });
	          },
	          checkPartAvailable: function checkPartAvailable(part) {
	            for (var i = 0; i < part.length; i++) {
	              // available может быть равно undefined в том случае, если это первый и единственный выбранный параметр
	              if (part[i]["available"] === true || part[i]["available"] === undefined) {
	                return true;
	              }
	            }

	            return false;
	          },
	          sendRequest: function sendRequest(data) {
	            var _this4 = this;

	            data["template"] = this.sTemplate;
	            data["parameters"] = this.sParams;
	            BX.ajax({
	              method: "POST",
	              dataType: "json",
	              url: this.action,
	              data: data,
	              onsuccess: function onsuccess(response) {
	                if (response.status && response.msg) {
	                  _this4.success = true;
	                  _this4.successMsg = response.msg;
	                  return;
	                } else {
	                  _this4.success = false;
	                  _this4.successMsg = '';

	                  if (response.photo) {
	                    _this4.mainImg = response.photo;
	                    _this4.photo = response.photo;
	                  } else {
	                    _this4.mainImg = _this4.defaultPhoto;
	                    _this4.photo = _this4.defaultPhoto;
	                  }

	                  _this4.parts[0].available = response["maxHeight"] && response["maxWidth"];
	                  _this4.parts[1].available = response["surface"].length ? _this4.checkPartAvailable(response["surface"]) : false;
	                  _this4.parts[2].available = response["base"].length ? _this4.checkPartAvailable(response["base"]) : false;
	                  _this4.parts[3].available = response["rec_colors"].length ? _this4.checkPartAvailable(response["rec_colors"]) : false;
	                  _this4.parts[4].available = response["drive"].length ? _this4.checkPartAvailable(response["drive"]) : false;
	                  _this4.parts[5].available = response["facings"].length ? _this4.checkPartAvailable(response["facings"]) : false;
	                  _this4.parts[6].available = response["glass"].length ? _this4.checkPartAvailable(response["glass"]) : false;

	                  for (var responseKey in response) {
	                    if (!response.hasOwnProperty(responseKey)) {
	                      continue;
	                    }

	                    if (_this4.hasOwnProperty(responseKey)) {
	                      _this4[responseKey] = response[responseKey];
	                    }
	                  }

	                  if (_this4.maxWidth && _this4.maxHeight) {
	                    var widthParams = {
	                      min: _this4.minWidth,
	                      max: _this4.maxWidth
	                    };
	                    var heightParams = {
	                      min: _this4.minHeight,
	                      max: _this4.maxHeight
	                    };

	                    var valids = _this4.getSizeValidators(widthParams, heightParams);

	                    _this4.$setValidators(valids);
	                  }

	                  _this4.sizes = response.sizes;
	                  BX.UI.Hint.init(BX('calculator-container'));
	                }

	                if (response.status && response.msg) ;
	              }
	            });
	          },
	          getSizeValidators: function getSizeValidators(width, height) {
	            return {
	              "selected.width": function selectedWidth(value) {
	                return Validator.value(value).digit("Допустим ввод только цифр").between(width.min, width.max, "\u0414\u043E\u043F\u0443\u0441\u0442\u0438\u043C\u043E \u043E\u0442 ".concat(width.min, " \u0434\u043E ").concat(width.max));
	              },
	              "selected.height": function selectedHeight(value) {
	                return Validator.value(value).digit("Допустим ввод только цифр").between(height.min, height.max, "\u0414\u043E\u043F\u0443\u0441\u0442\u0438\u043C\u043E \u043E\u0442 ".concat(height.min, " \u0434\u043E ").concat(height.max));
	              }
	            };
	          },
	          getPersonalValidators: function getPersonalValidators() {
	            return {
	              'phone': function phone(value) {
	                if (this.submitted) {
	                  return Validator.value(value).required('Поле обязательно для заполнения').regex(/\+7\s\(\d{3}\)\s\d{3}\s\d{2}-\d{2}/, 'Некорректный номер телефона');
	                }
	              },
	              'email': function email(value) {
	                if (this.submitted) {
	                  return Validator.value(value).required('Поле обязательно для заполнения').email('Не корректный e-mail');
	                }
	              },
	              'name': function name$$1(value) {
	                if (this.submitted) {
	                  return Validator.value(value).required('Поле обязательно для заполнения');
	                }
	              },
	              'lastName': function lastName(value) {
	                if (this.submitted) {
	                  return Validator.value(value).required('Поле обязательно для заполнения');
	                }
	              },
	              'city': function city(value) {
	                if (this.submitted) {
	                  return Validator.value(value).required('Поле обязательно для заполнения');
	                }
	              }
	            };
	          },
	          setSize: function setSize(payload) {
	            this.selected[payload.type] = +payload.value;
	          },
	          userSelected: function userSelected(payload) {
	            console.log(payload);
	            this.selected[payload.name] = payload.selected;
	            this.recalculate(payload.name);
	            /* if (this.photo) {
	                this.mainImg = this.photo;
	            } else {
	                if (payload.name === "surface" || payload.name === "base") {
	                    const selectedId = +payload.selected;
	                     for (const item of this[payload.name]) {
	                        if (item.id == selectedId && item.img) {
	                            this.mainImg = item.img;
	                        }
	                    }
	                }
	            }
	             if (!this.mainImg) {
	                this.mainImg = this.defaultPhoto;
	            } */
	          },
	          test: function test() {
	            var validators = this.getPersonalValidators();
	            this.$setValidators(validators);
	          }
	        },
	        mixins: [src.mixin],
	        validators: {}
	      });
	      this.vueComponent.setData(this.params);
	      this.vueComponent.setAjaxParams(this.params);
	      return this.vueComponent;
	    }
	  }]);
	  return Calculator;
	}();

	exports.Calculator = Calculator;

}((this.BX.Asteq = this.BX.Asteq || {}),BX));
//# sourceMappingURL=calculator.bundle.js.map
