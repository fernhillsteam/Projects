// source --> https://vizulab.com.au/wp-content/plugins/zoho-crm-forms/assets/js/moment-with-locales.js?ver=1.7.4.1 
//! moment.js
//! version : 2.9.0
//! authors : Tim Wood, Iskren Chernev, Moment.js contributors
//! license : MIT
//! momentjs.com

(function (undefined) {
    /************************************
     Constants
     ************************************/

    var moment,
            VERSION = '2.9.0',
            // the global-scope this is NOT the global object in Node.js
            globalScope = (typeof global !== 'undefined' && (typeof window === 'undefined' || window === global.window)) ? global : this,
            oldGlobalMoment,
            round = Math.round,
            hasOwnProperty = Object.prototype.hasOwnProperty,
            i,
            YEAR = 0,
            MONTH = 1,
            DATE = 2,
            HOUR = 3,
            MINUTE = 4,
            SECOND = 5,
            MILLISECOND = 6,
            // internal storage for locale config files
            locales = {},
            // extra moment internal properties (plugins register props here)
            momentProperties = [],
            // check for nodeJS
            hasModule = (typeof module !== 'undefined' && module && module.exports),
            // ASP.NET json date format regex
            aspNetJsonRegex = /^\/?Date\((\-?\d+)/i,
            aspNetTimeSpanJsonRegex = /(\-)?(?:(\d*)\.)?(\d+)\:(\d+)(?:\:(\d+)\.?(\d{3})?)?/,
            // from http://docs.closure-library.googlecode.com/git/closure_goog_date_date.js.source.html
            // somewhat more in line with 4.4.3.2 2004 spec, but allows decimal anywhere
            isoDurationRegex = /^(-)?P(?:(?:([0-9,.]*)Y)?(?:([0-9,.]*)M)?(?:([0-9,.]*)D)?(?:T(?:([0-9,.]*)H)?(?:([0-9,.]*)M)?(?:([0-9,.]*)S)?)?|([0-9,.]*)W)$/,
            // format tokens
            formattingTokens = /(\[[^\[]*\])|(\\)?(Mo|MM?M?M?|Do|DDDo|DD?D?D?|ddd?d?|do?|w[o|w]?|W[o|W]?|Q|YYYYYY|YYYYY|YYYY|YY|gg(ggg?)?|GG(GGG?)?|e|E|a|A|hh?|HH?|mm?|ss?|S{1,4}|x|X|zz?|ZZ?|.)/g,
            localFormattingTokens = /(\[[^\[]*\])|(\\)?(LTS|LT|LL?L?L?|l{1,4})/g,
            // parsing token regexes
            parseTokenOneOrTwoDigits = /\d\d?/, // 0 - 99
            parseTokenOneToThreeDigits = /\d{1,3}/, // 0 - 999
            parseTokenOneToFourDigits = /\d{1,4}/, // 0 - 9999
            parseTokenOneToSixDigits = /[+\-]?\d{1,6}/, // -999,999 - 999,999
            parseTokenDigits = /\d+/, // nonzero number of digits
            parseTokenWord = /[0-9]*['a-z\u00A0-\u05FF\u0700-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+|[\u0600-\u06FF\/]+(\s*?[\u0600-\u06FF]+){1,2}/i, // any word (or two) characters or numbers including two/three word month in arabic.
            parseTokenTimezone = /Z|[\+\-]\d\d:?\d\d/gi, // +00:00 -00:00 +0000 -0000 or Z
            parseTokenT = /T/i, // T (ISO separator)
            parseTokenOffsetMs = /[\+\-]?\d+/, // 1234567890123
            parseTokenTimestampMs = /[\+\-]?\d+(\.\d{1,3})?/, // 123456789 123456789.123

            //strict parsing regexes
            parseTokenOneDigit = /\d/, // 0 - 9
            parseTokenTwoDigits = /\d\d/, // 00 - 99
            parseTokenThreeDigits = /\d{3}/, // 000 - 999
            parseTokenFourDigits = /\d{4}/, // 0000 - 9999
            parseTokenSixDigits = /[+-]?\d{6}/, // -999,999 - 999,999
            parseTokenSignedNumber = /[+-]?\d+/, // -inf - inf

            // iso 8601 regex
            // 0000-00-00 0000-W00 or 0000-W00-0 + T + 00 or 00:00 or 00:00:00 or 00:00:00.000 + +00:00 or +0000 or +00)
            isoRegex = /^\s*(?:[+-]\d{6}|\d{4})-(?:(\d\d-\d\d)|(W\d\d$)|(W\d\d-\d)|(\d\d\d))((T| )(\d\d(:\d\d(:\d\d(\.\d+)?)?)?)?([\+\-]\d\d(?::?\d\d)?|\s*Z)?)?$/,
            isoFormat = 'YYYY-MM-DDTHH:mm:ssZ',
            isoDates = [
                ['YYYYYY-MM-DD', /[+-]\d{6}-\d{2}-\d{2}/],
                ['YYYY-MM-DD', /\d{4}-\d{2}-\d{2}/],
                ['GGGG-[W]WW-E', /\d{4}-W\d{2}-\d/],
                ['GGGG-[W]WW', /\d{4}-W\d{2}/],
                ['YYYY-DDD', /\d{4}-\d{3}/]
            ],
            // iso time formats and regexes
            isoTimes = [
                ['HH:mm:ss.SSSS', /(T| )\d\d:\d\d:\d\d\.\d+/],
                ['HH:mm:ss', /(T| )\d\d:\d\d:\d\d/],
                ['HH:mm', /(T| )\d\d:\d\d/],
                ['HH', /(T| )\d\d/]
            ],
            // timezone chunker '+10:00' > ['10', '00'] or '-1530' > ['-', '15', '30']
            parseTimezoneChunker = /([\+\-]|\d\d)/gi,
            // getter and setter names
            proxyGettersAndSetters = 'Date|Hours|Minutes|Seconds|Milliseconds'.split('|'),
            unitMillisecondFactors = {
                'Milliseconds': 1,
                'Seconds': 1e3,
                'Minutes': 6e4,
                'Hours': 36e5,
                'Days': 864e5,
                'Months': 2592e6,
                'Years': 31536e6
            },
            unitAliases = {
                ms: 'millisecond',
                s: 'second',
                m: 'minute',
                h: 'hour',
                d: 'day',
                D: 'date',
                w: 'week',
                W: 'isoWeek',
                M: 'month',
                Q: 'quarter',
                y: 'year',
                DDD: 'dayOfYear',
                e: 'weekday',
                E: 'isoWeekday',
                gg: 'weekYear',
                GG: 'isoWeekYear'
            },
            camelFunctions = {
                dayofyear: 'dayOfYear',
                isoweekday: 'isoWeekday',
                isoweek: 'isoWeek',
                weekyear: 'weekYear',
                isoweekyear: 'isoWeekYear'
            },
            // format function strings
            formatFunctions = {},
            // default relative time thresholds
            relativeTimeThresholds = {
                s: 45, // seconds to minute
                m: 45, // minutes to hour
                h: 22, // hours to day
                d: 26, // days to month
                M: 11   // months to year
            },
            // tokens to ordinalize and pad
            ordinalizeTokens = 'DDD w W M D d'.split(' '),
            paddedTokens = 'M D H h m s w W'.split(' '),
            formatTokenFunctions = {
                M: function () {
                    return this.month() + 1;
                },
                MMM: function (format) {
                    return this.localeData().monthsShort(this, format);
                },
                MMMM: function (format) {
                    return this.localeData().months(this, format);
                },
                D: function () {
                    return this.date();
                },
                DDD: function () {
                    return this.dayOfYear();
                },
                d: function () {
                    return this.day();
                },
                dd: function (format) {
                    return this.localeData().weekdaysMin(this, format);
                },
                ddd: function (format) {
                    return this.localeData().weekdaysShort(this, format);
                },
                dddd: function (format) {
                    return this.localeData().weekdays(this, format);
                },
                w: function () {
                    return this.week();
                },
                W: function () {
                    return this.isoWeek();
                },
                YY: function () {
                    return leftZeroFill(this.year() % 100, 2);
                },
                YYYY: function () {
                    return leftZeroFill(this.year(), 4);
                },
                YYYYY: function () {
                    return leftZeroFill(this.year(), 5);
                },
                YYYYYY: function () {
                    var y = this.year(), sign = y >= 0 ? '+' : '-';
                    return sign + leftZeroFill(Math.abs(y), 6);
                },
                gg: function () {
                    return leftZeroFill(this.weekYear() % 100, 2);
                },
                gggg: function () {
                    return leftZeroFill(this.weekYear(), 4);
                },
                ggggg: function () {
                    return leftZeroFill(this.weekYear(), 5);
                },
                GG: function () {
                    return leftZeroFill(this.isoWeekYear() % 100, 2);
                },
                GGGG: function () {
                    return leftZeroFill(this.isoWeekYear(), 4);
                },
                GGGGG: function () {
                    return leftZeroFill(this.isoWeekYear(), 5);
                },
                e: function () {
                    return this.weekday();
                },
                E: function () {
                    return this.isoWeekday();
                },
                a: function () {
                    return this.localeData().meridiem(this.hours(), this.minutes(), true);
                },
                A: function () {
                    return this.localeData().meridiem(this.hours(), this.minutes(), false);
                },
                H: function () {
                    return this.hours();
                },
                h: function () {
                    return this.hours() % 12 || 12;
                },
                m: function () {
                    return this.minutes();
                },
                s: function () {
                    return this.seconds();
                },
                S: function () {
                    return toInt(this.milliseconds() / 100);
                },
                SS: function () {
                    return leftZeroFill(toInt(this.milliseconds() / 10), 2);
                },
                SSS: function () {
                    return leftZeroFill(this.milliseconds(), 3);
                },
                SSSS: function () {
                    return leftZeroFill(this.milliseconds(), 3);
                },
                Z: function () {
                    var a = this.utcOffset(),
                            b = '+';
                    if (a < 0) {
                        a = -a;
                        b = '-';
                    }
                    return b + leftZeroFill(toInt(a / 60), 2) + ':' + leftZeroFill(toInt(a) % 60, 2);
                },
                ZZ: function () {
                    var a = this.utcOffset(),
                            b = '+';
                    if (a < 0) {
                        a = -a;
                        b = '-';
                    }
                    return b + leftZeroFill(toInt(a / 60), 2) + leftZeroFill(toInt(a) % 60, 2);
                },
                z: function () {
                    return this.zoneAbbr();
                },
                zz: function () {
                    return this.zoneName();
                },
                x: function () {
                    return this.valueOf();
                },
                X: function () {
                    return this.unix();
                },
                Q: function () {
                    return this.quarter();
                }
            },
            deprecations = {},
            lists = ['months', 'monthsShort', 'weekdays', 'weekdaysShort', 'weekdaysMin'],
            updateInProgress = false;

    // Pick the first defined of two or three arguments. dfl comes from
    // default.
    function dfl(a, b, c) {
        switch (arguments.length) {
            case 2:
                return a != null ? a : b;
            case 3:
                return a != null ? a : b != null ? b : c;
            default:
                throw new Error('Implement me');
        }
    }

    function hasOwnProp(a, b) {
        return hasOwnProperty.call(a, b);
    }

    function defaultParsingFlags() {
        // We need to deep clone this object, and es5 standard is not very
        // helpful.
        return {
            empty: false,
            unusedTokens: [],
            unusedInput: [],
            overflow: -2,
            charsLeftOver: 0,
            nullInput: false,
            invalidMonth: null,
            invalidFormat: false,
            userInvalidated: false,
            iso: false
        };
    }

    function printMsg(msg) {
        if (moment.suppressDeprecationWarnings === false &&
                typeof console !== 'undefined' && console.warn) {
            console.warn('Deprecation warning: ' + msg);
        }
    }

    function deprecate(msg, fn) {
        var firstTime = true;
        return extend(function () {
            if (firstTime) {
                printMsg(msg);
                firstTime = false;
            }
            return fn.apply(this, arguments);
        }, fn);
    }

    function deprecateSimple(name, msg) {
        if (!deprecations[name]) {
            printMsg(msg);
            deprecations[name] = true;
        }
    }

    function padToken(func, count) {
        return function (a) {
            return leftZeroFill(func.call(this, a), count);
        };
    }
    function ordinalizeToken(func, period) {
        return function (a) {
            return this.localeData().ordinal(func.call(this, a), period);
        };
    }

    function monthDiff(a, b) {
        // difference in months
        var wholeMonthDiff = ((b.year() - a.year()) * 12) + (b.month() - a.month()),
                // b is in (anchor - 1 month, anchor + 1 month)
                anchor = a.clone().add(wholeMonthDiff, 'months'),
                anchor2, adjust;

        if (b - anchor < 0) {
            anchor2 = a.clone().add(wholeMonthDiff - 1, 'months');
            // linear across the month
            adjust = (b - anchor) / (anchor - anchor2);
        } else {
            anchor2 = a.clone().add(wholeMonthDiff + 1, 'months');
            // linear across the month
            adjust = (b - anchor) / (anchor2 - anchor);
        }

        return -(wholeMonthDiff + adjust);
    }

    while (ordinalizeTokens.length) {
        i = ordinalizeTokens.pop();
        formatTokenFunctions[i + 'o'] = ordinalizeToken(formatTokenFunctions[i], i);
    }
    while (paddedTokens.length) {
        i = paddedTokens.pop();
        formatTokenFunctions[i + i] = padToken(formatTokenFunctions[i], 2);
    }
    formatTokenFunctions.DDDD = padToken(formatTokenFunctions.DDD, 3);


    function meridiemFixWrap(locale, hour, meridiem) {
        var isPm;

        if (meridiem == null) {
            // nothing to do
            return hour;
        }
        if (locale.meridiemHour != null) {
            return locale.meridiemHour(hour, meridiem);
        } else if (locale.isPM != null) {
            // Fallback
            isPm = locale.isPM(meridiem);
            if (isPm && hour < 12) {
                hour += 12;
            }
            if (!isPm && hour === 12) {
                hour = 0;
            }
            return hour;
        } else {
            // thie is not supposed to happen
            return hour;
        }
    }

    /************************************
     Constructors
     ************************************/

    function Locale() {
    }

    // Moment prototype object
    function Moment(config, skipOverflow) {
        if (skipOverflow !== false) {
            checkOverflow(config);
        }
        copyConfig(this, config);
        this._d = new Date(+config._d);
        // Prevent infinite loop in case updateOffset creates new moment
        // objects.
        if (updateInProgress === false) {
            updateInProgress = true;
            moment.updateOffset(this);
            updateInProgress = false;
        }
    }

    // Duration Constructor
    function Duration(duration) {
        var normalizedInput = normalizeObjectUnits(duration),
                years = normalizedInput.year || 0,
                quarters = normalizedInput.quarter || 0,
                months = normalizedInput.month || 0,
                weeks = normalizedInput.week || 0,
                days = normalizedInput.day || 0,
                hours = normalizedInput.hour || 0,
                minutes = normalizedInput.minute || 0,
                seconds = normalizedInput.second || 0,
                milliseconds = normalizedInput.millisecond || 0;

        // representation for dateAddRemove
        this._milliseconds = +milliseconds +
                seconds * 1e3 + // 1000
                minutes * 6e4 + // 1000 * 60
                hours * 36e5; // 1000 * 60 * 60
        // Because of dateAddRemove treats 24 hours as different from a
        // day when working around DST, we need to store them separately
        this._days = +days +
                weeks * 7;
        // It is impossible translate months into days without knowing
        // which months you are are talking about, so we have to store
        // it separately.
        this._months = +months +
                quarters * 3 +
                years * 12;

        this._data = {};

        this._locale = moment.localeData();

        this._bubble();
    }

    /************************************
     Helpers
     ************************************/


    function extend(a, b) {
        for (var i in b) {
            if (hasOwnProp(b, i)) {
                a[i] = b[i];
            }
        }

        if (hasOwnProp(b, 'toString')) {
            a.toString = b.toString;
        }

        if (hasOwnProp(b, 'valueOf')) {
            a.valueOf = b.valueOf;
        }

        return a;
    }

    function copyConfig(to, from) {
        var i, prop, val;

        if (typeof from._isAMomentObject !== 'undefined') {
            to._isAMomentObject = from._isAMomentObject;
        }
        if (typeof from._i !== 'undefined') {
            to._i = from._i;
        }
        if (typeof from._f !== 'undefined') {
            to._f = from._f;
        }
        if (typeof from._l !== 'undefined') {
            to._l = from._l;
        }
        if (typeof from._strict !== 'undefined') {
            to._strict = from._strict;
        }
        if (typeof from._tzm !== 'undefined') {
            to._tzm = from._tzm;
        }
        if (typeof from._isUTC !== 'undefined') {
            to._isUTC = from._isUTC;
        }
        if (typeof from._offset !== 'undefined') {
            to._offset = from._offset;
        }
        if (typeof from._pf !== 'undefined') {
            to._pf = from._pf;
        }
        if (typeof from._locale !== 'undefined') {
            to._locale = from._locale;
        }

        if (momentProperties.length > 0) {
            for (i in momentProperties) {
                prop = momentProperties[i];
                val = from[prop];
                if (typeof val !== 'undefined') {
                    to[prop] = val;
                }
            }
        }

        return to;
    }

    function absRound(number) {
        if (number < 0) {
            return Math.ceil(number);
        } else {
            return Math.floor(number);
        }
    }

    // left zero fill a number
    // see http://jsperf.com/left-zero-filling for performance comparison
    function leftZeroFill(number, targetLength, forceSign) {
        var output = '' + Math.abs(number),
                sign = number >= 0;

        while (output.length < targetLength) {
            output = '0' + output;
        }
        return (sign ? (forceSign ? '+' : '') : '-') + output;
    }

    function positiveMomentsDifference(base, other) {
        var res = {milliseconds: 0, months: 0};

        res.months = other.month() - base.month() +
                (other.year() - base.year()) * 12;
        if (base.clone().add(res.months, 'M').isAfter(other)) {
            --res.months;
        }

        res.milliseconds = +other - +(base.clone().add(res.months, 'M'));

        return res;
    }

    function momentsDifference(base, other) {
        var res;
        other = makeAs(other, base);
        if (base.isBefore(other)) {
            res = positiveMomentsDifference(base, other);
        } else {
            res = positiveMomentsDifference(other, base);
            res.milliseconds = -res.milliseconds;
            res.months = -res.months;
        }

        return res;
    }

    // TODO: remove 'name' arg after deprecation is removed
    function createAdder(direction, name) {
        return function (val, period) {
            var dur, tmp;
            //invert the arguments, but complain about it
            if (period !== null && !isNaN(+period)) {
                deprecateSimple(name, 'moment().' + name + '(period, number) is deprecated. Please use moment().' + name + '(number, period).');
                tmp = val;
                val = period;
                period = tmp;
            }

            val = typeof val === 'string' ? +val : val;
            dur = moment.duration(val, period);
            addOrSubtractDurationFromMoment(this, dur, direction);
            return this;
        };
    }

    function addOrSubtractDurationFromMoment(mom, duration, isAdding, updateOffset) {
        var milliseconds = duration._milliseconds,
                days = duration._days,
                months = duration._months;
        updateOffset = updateOffset == null ? true : updateOffset;

        if (milliseconds) {
            mom._d.setTime(+mom._d + milliseconds * isAdding);
        }
        if (days) {
            rawSetter(mom, 'Date', rawGetter(mom, 'Date') + days * isAdding);
        }
        if (months) {
            rawMonthSetter(mom, rawGetter(mom, 'Month') + months * isAdding);
        }
        if (updateOffset) {
            moment.updateOffset(mom, days || months);
        }
    }

    // check if is an array
    function isArray(input) {
        return Object.prototype.toString.call(input) === '[object Array]';
    }

    function isDate(input) {
        return Object.prototype.toString.call(input) === '[object Date]' ||
                input instanceof Date;
    }

    // compare two arrays, return the number of differences
    function compareArrays(array1, array2, dontConvert) {
        var len = Math.min(array1.length, array2.length),
                lengthDiff = Math.abs(array1.length - array2.length),
                diffs = 0,
                i;
        for (i = 0; i < len; i++) {
            if ((dontConvert && array1[i] !== array2[i]) ||
                    (!dontConvert && toInt(array1[i]) !== toInt(array2[i]))) {
                diffs++;
            }
        }
        return diffs + lengthDiff;
    }

    function normalizeUnits(units) {
        if (units) {
            var lowered = units.toLowerCase().replace(/(.)s$/, '$1');
            units = unitAliases[units] || camelFunctions[lowered] || lowered;
        }
        return units;
    }

    function normalizeObjectUnits(inputObject) {
        var normalizedInput = {},
                normalizedProp,
                prop;

        for (prop in inputObject) {
            if (hasOwnProp(inputObject, prop)) {
                normalizedProp = normalizeUnits(prop);
                if (normalizedProp) {
                    normalizedInput[normalizedProp] = inputObject[prop];
                }
            }
        }

        return normalizedInput;
    }

    function makeList(field) {
        var count, setter;

        if (field.indexOf('week') === 0) {
            count = 7;
            setter = 'day';
        } else if (field.indexOf('month') === 0) {
            count = 12;
            setter = 'month';
        } else {
            return;
        }

        moment[field] = function (format, index) {
            var i, getter,
                    method = moment._locale[field],
                    results = [];

            if (typeof format === 'number') {
                index = format;
                format = undefined;
            }

            getter = function (i) {
                var m = moment().utc().set(setter, i);
                return method.call(moment._locale, m, format || '');
            };

            if (index != null) {
                return getter(index);
            } else {
                for (i = 0; i < count; i++) {
                    results.push(getter(i));
                }
                return results;
            }
        };
    }

    function toInt(argumentForCoercion) {
        var coercedNumber = +argumentForCoercion,
                value = 0;

        if (coercedNumber !== 0 && isFinite(coercedNumber)) {
            if (coercedNumber >= 0) {
                value = Math.floor(coercedNumber);
            } else {
                value = Math.ceil(coercedNumber);
            }
        }

        return value;
    }

    function daysInMonth(year, month) {
        return new Date(Date.UTC(year, month + 1, 0)).getUTCDate();
    }

    function weeksInYear(year, dow, doy) {
        return weekOfYear(moment([year, 11, 31 + dow - doy]), dow, doy).week;
    }

    function daysInYear(year) {
        return isLeapYear(year) ? 366 : 365;
    }

    function isLeapYear(year) {
        return (year % 4 === 0 && year % 100 !== 0) || year % 400 === 0;
    }

    function checkOverflow(m) {
        var overflow;
        if (m._a && m._pf.overflow === -2) {
            overflow =
                    m._a[MONTH] < 0 || m._a[MONTH] > 11 ? MONTH :
                    m._a[DATE] < 1 || m._a[DATE] > daysInMonth(m._a[YEAR], m._a[MONTH]) ? DATE :
                    m._a[HOUR] < 0 || m._a[HOUR] > 24 ||
                    (m._a[HOUR] === 24 && (m._a[MINUTE] !== 0 ||
                            m._a[SECOND] !== 0 ||
                            m._a[MILLISECOND] !== 0)) ? HOUR :
                    m._a[MINUTE] < 0 || m._a[MINUTE] > 59 ? MINUTE :
                    m._a[SECOND] < 0 || m._a[SECOND] > 59 ? SECOND :
                    m._a[MILLISECOND] < 0 || m._a[MILLISECOND] > 999 ? MILLISECOND :
                    -1;

            if (m._pf._overflowDayOfYear && (overflow < YEAR || overflow > DATE)) {
                overflow = DATE;
            }

            m._pf.overflow = overflow;
        }
    }

    function isValid(m) {
        if (m._isValid == null) {
            m._isValid = !isNaN(m._d.getTime()) &&
                    m._pf.overflow < 0 &&
                    !m._pf.empty &&
                    !m._pf.invalidMonth &&
                    !m._pf.nullInput &&
                    !m._pf.invalidFormat &&
                    !m._pf.userInvalidated;

            if (m._strict) {
                m._isValid = m._isValid &&
                        m._pf.charsLeftOver === 0 &&
                        m._pf.unusedTokens.length === 0 &&
                        m._pf.bigHour === undefined;
            }
        }
        return m._isValid;
    }

    function normalizeLocale(key) {
        return key ? key.toLowerCase().replace('_', '-') : key;
    }

    // pick the locale from the array
    // try ['en-au', 'en-gb'] as 'en-au', 'en-gb', 'en', as in move through the list trying each
    // substring from most specific to least, but move to the next array item if it's a more specific variant than the current root
    function chooseLocale(names) {
        var i = 0, j, next, locale, split;

        while (i < names.length) {
            split = normalizeLocale(names[i]).split('-');
            j = split.length;
            next = normalizeLocale(names[i + 1]);
            next = next ? next.split('-') : null;
            while (j > 0) {
                locale = loadLocale(split.slice(0, j).join('-'));
                if (locale) {
                    return locale;
                }
                if (next && next.length >= j && compareArrays(split, next, true) >= j - 1) {
                    //the next array item is better than a shallower substring of this one
                    break;
                }
                j--;
            }
            i++;
        }
        return null;
    }

    function loadLocale(name) {
        var oldLocale = null;
        if (!locales[name] && hasModule) {
            try {
                oldLocale = moment.locale();
                require('./locale/' + name);
                // because defineLocale currently also sets the global locale, we want to undo that for lazy loaded locales
                moment.locale(oldLocale);
            } catch (e) {
            }
        }
        return locales[name];
    }

    // Return a moment from input, that is local/utc/utcOffset equivalent to
    // model.
    function makeAs(input, model) {
        var res, diff;
        if (model._isUTC) {
            res = model.clone();
            diff = (moment.isMoment(input) || isDate(input) ?
                    +input : +moment(input)) - (+res);
            // Use low-level api, because this fn is low-level api.
            res._d.setTime(+res._d + diff);
            moment.updateOffset(res, false);
            return res;
        } else {
            return moment(input).local();
        }
    }

    /************************************
     Locale
     ************************************/


    extend(Locale.prototype, {

        set: function (config) {
            var prop, i;
            for (i in config) {
                prop = config[i];
                if (typeof prop === 'function') {
                    this[i] = prop;
                } else {
                    this['_' + i] = prop;
                }
            }
            // Lenient ordinal parsing accepts just a number in addition to
            // number + (possibly) stuff coming from _ordinalParseLenient.
            this._ordinalParseLenient = new RegExp(this._ordinalParse.source + '|' + /\d{1,2}/.source);
        },

        _months: 'January_February_March_April_May_June_July_August_September_October_November_December'.split('_'),
        months: function (m) {
            return this._months[m.month()];
        },

        _monthsShort: 'Jan_Feb_Mar_Apr_May_Jun_Jul_Aug_Sep_Oct_Nov_Dec'.split('_'),
        monthsShort: function (m) {
            return this._monthsShort[m.month()];
        },

        monthsParse: function (monthName, format, strict) {
            var i, mom, regex;

            if (!this._monthsParse) {
                this._monthsParse = [];
                this._longMonthsParse = [];
                this._shortMonthsParse = [];
            }

            for (i = 0; i < 12; i++) {
                // make the regex if we don't have it already
                mom = moment.utc([2000, i]);
                if (strict && !this._longMonthsParse[i]) {
                    this._longMonthsParse[i] = new RegExp('^' + this.months(mom, '').replace('.', '') + '$', 'i');
                    this._shortMonthsParse[i] = new RegExp('^' + this.monthsShort(mom, '').replace('.', '') + '$', 'i');
                }
                if (!strict && !this._monthsParse[i]) {
                    regex = '^' + this.months(mom, '') + '|^' + this.monthsShort(mom, '');
                    this._monthsParse[i] = new RegExp(regex.replace('.', ''), 'i');
                }
                // test the regex
                if (strict && format === 'MMMM' && this._longMonthsParse[i].test(monthName)) {
                    return i;
                } else if (strict && format === 'MMM' && this._shortMonthsParse[i].test(monthName)) {
                    return i;
                } else if (!strict && this._monthsParse[i].test(monthName)) {
                    return i;
                }
            }
        },

        _weekdays: 'Sunday_Monday_Tuesday_Wednesday_Thursday_Friday_Saturday'.split('_'),
        weekdays: function (m) {
            return this._weekdays[m.day()];
        },

        _weekdaysShort: 'Sun_Mon_Tue_Wed_Thu_Fri_Sat'.split('_'),
        weekdaysShort: function (m) {
            return this._weekdaysShort[m.day()];
        },

        _weekdaysMin: 'Su_Mo_Tu_We_Th_Fr_Sa'.split('_'),
        weekdaysMin: function (m) {
            return this._weekdaysMin[m.day()];
        },

        weekdaysParse: function (weekdayName) {
            var i, mom, regex;

            if (!this._weekdaysParse) {
                this._weekdaysParse = [];
            }

            for (i = 0; i < 7; i++) {
                // make the regex if we don't have it already
                if (!this._weekdaysParse[i]) {
                    mom = moment([2000, 1]).day(i);
                    regex = '^' + this.weekdays(mom, '') + '|^' + this.weekdaysShort(mom, '') + '|^' + this.weekdaysMin(mom, '');
                    this._weekdaysParse[i] = new RegExp(regex.replace('.', ''), 'i');
                }
                // test the regex
                if (this._weekdaysParse[i].test(weekdayName)) {
                    return i;
                }
            }
        },

        _longDateFormat: {
            LTS: 'h:mm:ss A',
            LT: 'h:mm A',
            L: 'MM/DD/YYYY',
            LL: 'MMMM D, YYYY',
            LLL: 'MMMM D, YYYY LT',
            LLLL: 'dddd, MMMM D, YYYY LT'
        },
        longDateFormat: function (key) {
            var output = this._longDateFormat[key];
            if (!output && this._longDateFormat[key.toUpperCase()]) {
                output = this._longDateFormat[key.toUpperCase()].replace(/MMMM|MM|DD|dddd/g, function (val) {
                    return val.slice(1);
                });
                this._longDateFormat[key] = output;
            }
            return output;
        },

        isPM: function (input) {
            // IE8 Quirks Mode & IE7 Standards Mode do not allow accessing strings like arrays
            // Using charAt should be more compatible.
            return ((input + '').toLowerCase().charAt(0) === 'p');
        },

        _meridiemParse: /[ap]\.?m?\.?/i,
        meridiem: function (hours, minutes, isLower) {
            if (hours > 11) {
                return isLower ? 'pm' : 'PM';
            } else {
                return isLower ? 'am' : 'AM';
            }
        },

        _calendar: {
            sameDay: '[Today at] LT',
            nextDay: '[Tomorrow at] LT',
            nextWeek: 'dddd [at] LT',
            lastDay: '[Yesterday at] LT',
            lastWeek: '[Last] dddd [at] LT',
            sameElse: 'L'
        },
        calendar: function (key, mom, now) {
            var output = this._calendar[key];
            return typeof output === 'function' ? output.apply(mom, [now]) : output;
        },

        _relativeTime: {
            future: 'in %s',
            past: '%s ago',
            s: 'a few seconds',
            m: 'a minute',
            mm: '%d minutes',
            h: 'an hour',
            hh: '%d hours',
            d: 'a day',
            dd: '%d days',
            M: 'a month',
            MM: '%d months',
            y: 'a year',
            yy: '%d years'
        },

        relativeTime: function (number, withoutSuffix, string, isFuture) {
            var output = this._relativeTime[string];
            return (typeof output === 'function') ?
                    output(number, withoutSuffix, string, isFuture) :
                    output.replace(/%d/i, number);
        },

        pastFuture: function (diff, output) {
            var format = this._relativeTime[diff > 0 ? 'future' : 'past'];
            return typeof format === 'function' ? format(output) : format.replace(/%s/i, output);
        },

        ordinal: function (number) {
            return this._ordinal.replace('%d', number);
        },
        _ordinal: '%d',
        _ordinalParse: /\d{1,2}/,

        preparse: function (string) {
            return string;
        },

        postformat: function (string) {
            return string;
        },

        week: function (mom) {
            return weekOfYear(mom, this._week.dow, this._week.doy).week;
        },

        _week: {
            dow: 0, // Sunday is the first day of the week.
            doy: 6  // The week that contains Jan 1st is the first week of the year.
        },

        firstDayOfWeek: function () {
            return this._week.dow;
        },

        firstDayOfYear: function () {
            return this._week.doy;
        },

        _invalidDate: 'Invalid date',
        invalidDate: function () {
            return this._invalidDate;
        }
    });

    /************************************
     Formatting
     ************************************/


    function removeFormattingTokens(input) {
        if (input.match(/\[[\s\S]/)) {
            return input.replace(/^\[|\]$/g, '');
        }
        return input.replace(/\\/g, '');
    }

    function makeFormatFunction(format) {
        var array = format.match(formattingTokens), i, length;

        for (i = 0, length = array.length; i < length; i++) {
            if (formatTokenFunctions[array[i]]) {
                array[i] = formatTokenFunctions[array[i]];
            } else {
                array[i] = removeFormattingTokens(array[i]);
            }
        }

        return function (mom) {
            var output = '';
            for (i = 0; i < length; i++) {
                output += array[i] instanceof Function ? array[i].call(mom, format) : array[i];
            }
            return output;
        };
    }

    // format date using native date object
    function formatMoment(m, format) {
        if (!m.isValid()) {
            return m.localeData().invalidDate();
        }

        format = expandFormat(format, m.localeData());

        if (!formatFunctions[format]) {
            formatFunctions[format] = makeFormatFunction(format);
        }

        return formatFunctions[format](m);
    }

    function expandFormat(format, locale) {
        var i = 5;

        function replaceLongDateFormatTokens(input) {
            return locale.longDateFormat(input) || input;
        }

        localFormattingTokens.lastIndex = 0;
        while (i >= 0 && localFormattingTokens.test(format)) {
            format = format.replace(localFormattingTokens, replaceLongDateFormatTokens);
            localFormattingTokens.lastIndex = 0;
            i -= 1;
        }

        return format;
    }


    /************************************
     Parsing
     ************************************/


    // get the regex to find the next token
    function getParseRegexForToken(token, config) {
        var a, strict = config._strict;
        switch (token) {
            case 'Q':
                return parseTokenOneDigit;
            case 'DDDD':
                return parseTokenThreeDigits;
            case 'YYYY':
            case 'GGGG':
            case 'gggg':
                return strict ? parseTokenFourDigits : parseTokenOneToFourDigits;
            case 'Y':
            case 'G':
            case 'g':
                return parseTokenSignedNumber;
            case 'YYYYYY':
            case 'YYYYY':
            case 'GGGGG':
            case 'ggggg':
                return strict ? parseTokenSixDigits : parseTokenOneToSixDigits;
            case 'S':
                if (strict) {
                    return parseTokenOneDigit;
                }
                /* falls through */
            case 'SS':
                if (strict) {
                    return parseTokenTwoDigits;
                }
                /* falls through */
            case 'SSS':
                if (strict) {
                    return parseTokenThreeDigits;
                }
                /* falls through */
            case 'DDD':
                return parseTokenOneToThreeDigits;
            case 'MMM':
            case 'MMMM':
            case 'dd':
            case 'ddd':
            case 'dddd':
                return parseTokenWord;
            case 'a':
            case 'A':
                return config._locale._meridiemParse;
            case 'x':
                return parseTokenOffsetMs;
            case 'X':
                return parseTokenTimestampMs;
            case 'Z':
            case 'ZZ':
                return parseTokenTimezone;
            case 'T':
                return parseTokenT;
            case 'SSSS':
                return parseTokenDigits;
            case 'MM':
            case 'DD':
            case 'YY':
            case 'GG':
            case 'gg':
            case 'HH':
            case 'hh':
            case 'mm':
            case 'ss':
            case 'ww':
            case 'WW':
                return strict ? parseTokenTwoDigits : parseTokenOneOrTwoDigits;
            case 'M':
            case 'D':
            case 'd':
            case 'H':
            case 'h':
            case 'm':
            case 's':
            case 'w':
            case 'W':
            case 'e':
            case 'E':
                return parseTokenOneOrTwoDigits;
            case 'Do':
                return strict ? config._locale._ordinalParse : config._locale._ordinalParseLenient;
            default :
                a = new RegExp(regexpEscape(unescapeFormat(token.replace('\\', '')), 'i'));
                return a;
        }
    }

    function utcOffsetFromString(string) {
        string = string || '';
        var possibleTzMatches = (string.match(parseTokenTimezone) || []),
                tzChunk = possibleTzMatches[possibleTzMatches.length - 1] || [],
                parts = (tzChunk + '').match(parseTimezoneChunker) || ['-', 0, 0],
                minutes = +(parts[1] * 60) + toInt(parts[2]);

        return parts[0] === '+' ? minutes : -minutes;
    }

    // function to convert string input to date
    function addTimeToArrayFromToken(token, input, config) {
        var a, datePartArray = config._a;

        switch (token) {
            // QUARTER
            case 'Q':
                if (input != null) {
                    datePartArray[MONTH] = (toInt(input) - 1) * 3;
                }
                break;
                // MONTH
            case 'M' : // fall through to MM
            case 'MM' :
                if (input != null) {
                    datePartArray[MONTH] = toInt(input) - 1;
                }
                break;
            case 'MMM' : // fall through to MMMM
            case 'MMMM' :
                a = config._locale.monthsParse(input, token, config._strict);
                // if we didn't find a month name, mark the date as invalid.
                if (a != null) {
                    datePartArray[MONTH] = a;
                } else {
                    config._pf.invalidMonth = input;
                }
                break;
                // DAY OF MONTH
            case 'D' : // fall through to DD
            case 'DD' :
                if (input != null) {
                    datePartArray[DATE] = toInt(input);
                }
                break;
            case 'Do' :
                if (input != null) {
                    datePartArray[DATE] = toInt(parseInt(
                            input.match(/\d{1,2}/)[0], 10));
                }
                break;
                // DAY OF YEAR
            case 'DDD' : // fall through to DDDD
            case 'DDDD' :
                if (input != null) {
                    config._dayOfYear = toInt(input);
                }

                break;
                // YEAR
            case 'YY' :
                datePartArray[YEAR] = moment.parseTwoDigitYear(input);
                break;
            case 'YYYY' :
            case 'YYYYY' :
            case 'YYYYYY' :
                datePartArray[YEAR] = toInt(input);
                break;
                // AM / PM
            case 'a' : // fall through to A
            case 'A' :
                config._meridiem = input;
                // config._isPm = config._locale.isPM(input);
                break;
                // HOUR
            case 'h' : // fall through to hh
            case 'hh' :
                config._pf.bigHour = true;
                /* falls through */
            case 'H' : // fall through to HH
            case 'HH' :
                datePartArray[HOUR] = toInt(input);
                break;
                // MINUTE
            case 'm' : // fall through to mm
            case 'mm' :
                datePartArray[MINUTE] = toInt(input);
                break;
                // SECOND
            case 's' : // fall through to ss
            case 'ss' :
                datePartArray[SECOND] = toInt(input);
                break;
                // MILLISECOND
            case 'S' :
            case 'SS' :
            case 'SSS' :
            case 'SSSS' :
                datePartArray[MILLISECOND] = toInt(('0.' + input) * 1000);
                break;
                // UNIX OFFSET (MILLISECONDS)
            case 'x':
                config._d = new Date(toInt(input));
                break;
                // UNIX TIMESTAMP WITH MS
            case 'X':
                config._d = new Date(parseFloat(input) * 1000);
                break;
                // TIMEZONE
            case 'Z' : // fall through to ZZ
            case 'ZZ' :
                config._useUTC = true;
                config._tzm = utcOffsetFromString(input);
                break;
                // WEEKDAY - human
            case 'dd':
            case 'ddd':
            case 'dddd':
                a = config._locale.weekdaysParse(input);
                // if we didn't get a weekday name, mark the date as invalid
                if (a != null) {
                    config._w = config._w || {};
                    config._w['d'] = a;
                } else {
                    config._pf.invalidWeekday = input;
                }
                break;
                // WEEK, WEEK DAY - numeric
            case 'w':
            case 'ww':
            case 'W':
            case 'WW':
            case 'd':
            case 'e':
            case 'E':
                token = token.substr(0, 1);
                /* falls through */
            case 'gggg':
            case 'GGGG':
            case 'GGGGG':
                token = token.substr(0, 2);
                if (input) {
                    config._w = config._w || {};
                    config._w[token] = toInt(input);
                }
                break;
            case 'gg':
            case 'GG':
                config._w = config._w || {};
                config._w[token] = moment.parseTwoDigitYear(input);
        }
    }

    function dayOfYearFromWeekInfo(config) {
        var w, weekYear, week, weekday, dow, doy, temp;

        w = config._w;
        if (w.GG != null || w.W != null || w.E != null) {
            dow = 1;
            doy = 4;

            // TODO: We need to take the current isoWeekYear, but that depends on
            // how we interpret now (local, utc, fixed offset). So create
            // a now version of current config (take local/utc/offset flags, and
            // create now).
            weekYear = dfl(w.GG, config._a[YEAR], weekOfYear(moment(), 1, 4).year);
            week = dfl(w.W, 1);
            weekday = dfl(w.E, 1);
        } else {
            dow = config._locale._week.dow;
            doy = config._locale._week.doy;

            weekYear = dfl(w.gg, config._a[YEAR], weekOfYear(moment(), dow, doy).year);
            week = dfl(w.w, 1);

            if (w.d != null) {
                // weekday -- low day numbers are considered next week
                weekday = w.d;
                if (weekday < dow) {
                    ++week;
                }
            } else if (w.e != null) {
                // local weekday -- counting starts from begining of week
                weekday = w.e + dow;
            } else {
                // default to begining of week
                weekday = dow;
            }
        }
        temp = dayOfYearFromWeeks(weekYear, week, weekday, doy, dow);

        config._a[YEAR] = temp.year;
        config._dayOfYear = temp.dayOfYear;
    }

    // convert an array to a date.
    // the array should mirror the parameters below
    // note: all values past the year are optional and will default to the lowest possible value.
    // [year, month, day , hour, minute, second, millisecond]
    function dateFromConfig(config) {
        var i, date, input = [], currentDate, yearToUse;

        if (config._d) {
            return;
        }

        currentDate = currentDateArray(config);

        //compute day of the year from weeks and weekdays
        if (config._w && config._a[DATE] == null && config._a[MONTH] == null) {
            dayOfYearFromWeekInfo(config);
        }

        //if the day of the year is set, figure out what it is
        if (config._dayOfYear) {
            yearToUse = dfl(config._a[YEAR], currentDate[YEAR]);

            if (config._dayOfYear > daysInYear(yearToUse)) {
                config._pf._overflowDayOfYear = true;
            }

            date = makeUTCDate(yearToUse, 0, config._dayOfYear);
            config._a[MONTH] = date.getUTCMonth();
            config._a[DATE] = date.getUTCDate();
        }

        // Default to current date.
        // * if no year, month, day of month are given, default to today
        // * if day of month is given, default month and year
        // * if month is given, default only year
        // * if year is given, don't default anything
        for (i = 0; i < 3 && config._a[i] == null; ++i) {
            config._a[i] = input[i] = currentDate[i];
        }

        // Zero out whatever was not defaulted, including time
        for (; i < 7; i++) {
            config._a[i] = input[i] = (config._a[i] == null) ? (i === 2 ? 1 : 0) : config._a[i];
        }

        // Check for 24:00:00.000
        if (config._a[HOUR] === 24 &&
                config._a[MINUTE] === 0 &&
                config._a[SECOND] === 0 &&
                config._a[MILLISECOND] === 0) {
            config._nextDay = true;
            config._a[HOUR] = 0;
        }

        config._d = (config._useUTC ? makeUTCDate : makeDate).apply(null, input);
        // Apply timezone offset from input. The actual utcOffset can be changed
        // with parseZone.
        if (config._tzm != null) {
            config._d.setUTCMinutes(config._d.getUTCMinutes() - config._tzm);
        }

        if (config._nextDay) {
            config._a[HOUR] = 24;
        }
    }

    function dateFromObject(config) {
        var normalizedInput;

        if (config._d) {
            return;
        }

        normalizedInput = normalizeObjectUnits(config._i);
        config._a = [
            normalizedInput.year,
            normalizedInput.month,
            normalizedInput.day || normalizedInput.date,
            normalizedInput.hour,
            normalizedInput.minute,
            normalizedInput.second,
            normalizedInput.millisecond
        ];

        dateFromConfig(config);
    }

    function currentDateArray(config) {
        var now = new Date();
        if (config._useUTC) {
            return [
                now.getUTCFullYear(),
                now.getUTCMonth(),
                now.getUTCDate()
            ];
        } else {
            return [now.getFullYear(), now.getMonth(), now.getDate()];
        }
    }

    // date from string and format string
    function makeDateFromStringAndFormat(config) {
        if (config._f === moment.ISO_8601) {
            parseISO(config);
            return;
        }

        config._a = [];
        config._pf.empty = true;

        // This array is used to make a Date, either with `new Date` or `Date.UTC`
        var string = '' + config._i,
                i, parsedInput, tokens, token, skipped,
                stringLength = string.length,
                totalParsedInputLength = 0;

        tokens = expandFormat(config._f, config._locale).match(formattingTokens) || [];

        for (i = 0; i < tokens.length; i++) {
            token = tokens[i];
            parsedInput = (string.match(getParseRegexForToken(token, config)) || [])[0];
            if (parsedInput) {
                skipped = string.substr(0, string.indexOf(parsedInput));
                if (skipped.length > 0) {
                    config._pf.unusedInput.push(skipped);
                }
                string = string.slice(string.indexOf(parsedInput) + parsedInput.length);
                totalParsedInputLength += parsedInput.length;
            }
            // don't parse if it's not a known token
            if (formatTokenFunctions[token]) {
                if (parsedInput) {
                    config._pf.empty = false;
                } else {
                    config._pf.unusedTokens.push(token);
                }
                addTimeToArrayFromToken(token, parsedInput, config);
            } else if (config._strict && !parsedInput) {
                config._pf.unusedTokens.push(token);
            }
        }

        // add remaining unparsed input length to the string
        config._pf.charsLeftOver = stringLength - totalParsedInputLength;
        if (string.length > 0) {
            config._pf.unusedInput.push(string);
        }

        // clear _12h flag if hour is <= 12
        if (config._pf.bigHour === true && config._a[HOUR] <= 12) {
            config._pf.bigHour = undefined;
        }
        // handle meridiem
        config._a[HOUR] = meridiemFixWrap(config._locale, config._a[HOUR],
                config._meridiem);
        dateFromConfig(config);
        checkOverflow(config);
    }

    function unescapeFormat(s) {
        return s.replace(/\\(\[)|\\(\])|\[([^\]\[]*)\]|\\(.)/g, function (matched, p1, p2, p3, p4) {
            return p1 || p2 || p3 || p4;
        });
    }

    // Code from http://stackoverflow.com/questions/3561493/is-there-a-regexp-escape-function-in-javascript
    function regexpEscape(s) {
        return s.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
    }

    // date from string and array of format strings
    function makeDateFromStringAndArray(config) {
        var tempConfig,
                bestMoment,
                scoreToBeat,
                i,
                currentScore;

        if (config._f.length === 0) {
            config._pf.invalidFormat = true;
            config._d = new Date(NaN);
            return;
        }

        for (i = 0; i < config._f.length; i++) {
            currentScore = 0;
            tempConfig = copyConfig({}, config);
            if (config._useUTC != null) {
                tempConfig._useUTC = config._useUTC;
            }
            tempConfig._pf = defaultParsingFlags();
            tempConfig._f = config._f[i];
            makeDateFromStringAndFormat(tempConfig);

            if (!isValid(tempConfig)) {
                continue;
            }

            // if there is any input that was not parsed add a penalty for that format
            currentScore += tempConfig._pf.charsLeftOver;

            //or tokens
            currentScore += tempConfig._pf.unusedTokens.length * 10;

            tempConfig._pf.score = currentScore;

            if (scoreToBeat == null || currentScore < scoreToBeat) {
                scoreToBeat = currentScore;
                bestMoment = tempConfig;
            }
        }

        extend(config, bestMoment || tempConfig);
    }

    // date from iso format
    function parseISO(config) {
        var i, l,
                string = config._i,
                match = isoRegex.exec(string);

        if (match) {
            config._pf.iso = true;
            for (i = 0, l = isoDates.length; i < l; i++) {
                if (isoDates[i][1].exec(string)) {
                    // match[5] should be 'T' or undefined
                    config._f = isoDates[i][0] + (match[6] || ' ');
                    break;
                }
            }
            for (i = 0, l = isoTimes.length; i < l; i++) {
                if (isoTimes[i][1].exec(string)) {
                    config._f += isoTimes[i][0];
                    break;
                }
            }
            if (string.match(parseTokenTimezone)) {
                config._f += 'Z';
            }
            makeDateFromStringAndFormat(config);
        } else {
            config._isValid = false;
        }
    }

    // date from iso format or fallback
    function makeDateFromString(config) {
        parseISO(config);
        if (config._isValid === false) {
            delete config._isValid;
            moment.createFromInputFallback(config);
        }
    }

    function map(arr, fn) {
        var res = [], i;
        for (i = 0; i < arr.length; ++i) {
            res.push(fn(arr[i], i));
        }
        return res;
    }

    function makeDateFromInput(config) {
        var input = config._i, matched;
        if (input === undefined) {
            config._d = new Date();
        } else if (isDate(input)) {
            config._d = new Date(+input);
        } else if ((matched = aspNetJsonRegex.exec(input)) !== null) {
            config._d = new Date(+matched[1]);
        } else if (typeof input === 'string') {
            makeDateFromString(config);
        } else if (isArray(input)) {
            config._a = map(input.slice(0), function (obj) {
                return parseInt(obj, 10);
            });
            dateFromConfig(config);
        } else if (typeof (input) === 'object') {
            dateFromObject(config);
        } else if (typeof (input) === 'number') {
            // from milliseconds
            config._d = new Date(input);
        } else {
            moment.createFromInputFallback(config);
        }
    }

    function makeDate(y, m, d, h, M, s, ms) {
        //can't just apply() to create a date:
        //http://stackoverflow.com/questions/181348/instantiating-a-javascript-object-by-callingtotype-constructor-apply
        var date = new Date(y, m, d, h, M, s, ms);

        //the date constructor doesn't accept years < 1970
        if (y < 1970) {
            date.setFullYear(y);
        }
        return date;
    }

    function makeUTCDate(y) {
        var date = new Date(Date.UTC.apply(null, arguments));
        if (y < 1970) {
            date.setUTCFullYear(y);
        }
        return date;
    }

    function parseWeekday(input, locale) {
        if (typeof input === 'string') {
            if (!isNaN(input)) {
                input = parseInt(input, 10);
            } else {
                input = locale.weekdaysParse(input);
                if (typeof input !== 'number') {
                    return null;
                }
            }
        }
        return input;
    }

    /************************************
     Relative Time
     ************************************/


    // helper function for moment.fn.from, moment.fn.fromNow, and moment.duration.fn.humanize
    function substituteTimeAgo(string, number, withoutSuffix, isFuture, locale) {
        return locale.relativeTime(number || 1, !!withoutSuffix, string, isFuture);
    }

    function relativeTime(posNegDuration, withoutSuffix, locale) {
        var duration = moment.duration(posNegDuration).abs(),
                seconds = round(duration.as('s')),
                minutes = round(duration.as('m')),
                hours = round(duration.as('h')),
                days = round(duration.as('d')),
                months = round(duration.as('M')),
                years = round(duration.as('y')),
                args = seconds < relativeTimeThresholds.s && ['s', seconds] ||
                minutes === 1 && ['m'] ||
                minutes < relativeTimeThresholds.m && ['mm', minutes] ||
                hours === 1 && ['h'] ||
                hours < relativeTimeThresholds.h && ['hh', hours] ||
                days === 1 && ['d'] ||
                days < relativeTimeThresholds.d && ['dd', days] ||
                months === 1 && ['M'] ||
                months < relativeTimeThresholds.M && ['MM', months] ||
                years === 1 && ['y'] || ['yy', years];

        args[2] = withoutSuffix;
        args[3] = +posNegDuration > 0;
        args[4] = locale;
        return substituteTimeAgo.apply({}, args);
    }


    /************************************
     Week of Year
     ************************************/


    // firstDayOfWeek       0 = sun, 6 = sat
    //                      the day of the week that starts the week
    //                      (usually sunday or monday)
    // firstDayOfWeekOfYear 0 = sun, 6 = sat
    //                      the first week is the week that contains the first
    //                      of this day of the week
    //                      (eg. ISO weeks use thursday (4))
    function weekOfYear(mom, firstDayOfWeek, firstDayOfWeekOfYear) {
        var end = firstDayOfWeekOfYear - firstDayOfWeek,
                daysToDayOfWeek = firstDayOfWeekOfYear - mom.day(),
                adjustedMoment;


        if (daysToDayOfWeek > end) {
            daysToDayOfWeek -= 7;
        }

        if (daysToDayOfWeek < end - 7) {
            daysToDayOfWeek += 7;
        }

        adjustedMoment = moment(mom).add(daysToDayOfWeek, 'd');
        return {
            week: Math.ceil(adjustedMoment.dayOfYear() / 7),
            year: adjustedMoment.year()
        };
    }

    //http://en.wikipedia.org/wiki/ISO_week_date#Calculating_a_date_given_the_year.2C_week_number_and_weekday
    function dayOfYearFromWeeks(year, week, weekday, firstDayOfWeekOfYear, firstDayOfWeek) {
        var d = makeUTCDate(year, 0, 1).getUTCDay(), daysToAdd, dayOfYear;

        d = d === 0 ? 7 : d;
        weekday = weekday != null ? weekday : firstDayOfWeek;
        daysToAdd = firstDayOfWeek - d + (d > firstDayOfWeekOfYear ? 7 : 0) - (d < firstDayOfWeek ? 7 : 0);
        dayOfYear = 7 * (week - 1) + (weekday - firstDayOfWeek) + daysToAdd + 1;

        return {
            year: dayOfYear > 0 ? year : year - 1,
            dayOfYear: dayOfYear > 0 ? dayOfYear : daysInYear(year - 1) + dayOfYear
        };
    }

    /************************************
     Top Level Functions
     ************************************/

    function makeMoment(config) {
        var input = config._i,
                format = config._f,
                res;

        config._locale = config._locale || moment.localeData(config._l);

        if (input === null || (format === undefined && input === '')) {
            return moment.invalid({nullInput: true});
        }

        if (typeof input === 'string') {
            config._i = input = config._locale.preparse(input);
        }

        if (moment.isMoment(input)) {
            return new Moment(input, true);
        } else if (format) {
            if (isArray(format)) {
                makeDateFromStringAndArray(config);
            } else {
                makeDateFromStringAndFormat(config);
            }
        } else {
            makeDateFromInput(config);
        }

        res = new Moment(config);
        if (res._nextDay) {
            // Adding is smart enough around DST
            res.add(1, 'd');
            res._nextDay = undefined;
        }

        return res;
    }

    moment = function (input, format, locale, strict) {
        var c;

        if (typeof (locale) === 'boolean') {
            strict = locale;
            locale = undefined;
        }
        // object construction must be done this way.
        // https://github.com/moment/moment/issues/1423
        c = {};
        c._isAMomentObject = true;
        c._i = input;
        c._f = format;
        c._l = locale;
        c._strict = strict;
        c._isUTC = false;
        c._pf = defaultParsingFlags();

        return makeMoment(c);
    };

    moment.suppressDeprecationWarnings = false;

    moment.createFromInputFallback = deprecate(
            'moment construction falls back to js Date. This is ' +
            'discouraged and will be removed in upcoming major ' +
            'release. Please refer to ' +
            'https://github.com/moment/moment/issues/1407 for more info.',
            function (config) {
                config._d = new Date(config._i + (config._useUTC ? ' UTC' : ''));
            }
    );

    // Pick a moment m from moments so that m[fn](other) is true for all
    // other. This relies on the function fn to be transitive.
    //
    // moments should either be an array of moment objects or an array, whose
    // first element is an array of moment objects.
    function pickBy(fn, moments) {
        var res, i;
        if (moments.length === 1 && isArray(moments[0])) {
            moments = moments[0];
        }
        if (!moments.length) {
            return moment();
        }
        res = moments[0];
        for (i = 1; i < moments.length; ++i) {
            if (moments[i][fn](res)) {
                res = moments[i];
            }
        }
        return res;
    }

    moment.min = function () {
        var args = [].slice.call(arguments, 0);

        return pickBy('isBefore', args);
    };

    moment.max = function () {
        var args = [].slice.call(arguments, 0);

        return pickBy('isAfter', args);
    };

    // creating with utc
    moment.utc = function (input, format, locale, strict) {
        var c;

        if (typeof (locale) === 'boolean') {
            strict = locale;
            locale = undefined;
        }
        // object construction must be done this way.
        // https://github.com/moment/moment/issues/1423
        c = {};
        c._isAMomentObject = true;
        c._useUTC = true;
        c._isUTC = true;
        c._l = locale;
        c._i = input;
        c._f = format;
        c._strict = strict;
        c._pf = defaultParsingFlags();

        return makeMoment(c).utc();
    };

    // creating with unix timestamp (in seconds)
    moment.unix = function (input) {
        return moment(input * 1000);
    };

    // duration
    moment.duration = function (input, key) {
        var duration = input,
                // matching against regexp is expensive, do it on demand
                match = null,
                sign,
                ret,
                parseIso,
                diffRes;

        if (moment.isDuration(input)) {
            duration = {
                ms: input._milliseconds,
                d: input._days,
                M: input._months
            };
        } else if (typeof input === 'number') {
            duration = {};
            if (key) {
                duration[key] = input;
            } else {
                duration.milliseconds = input;
            }
        } else if (!!(match = aspNetTimeSpanJsonRegex.exec(input))) {
            sign = (match[1] === '-') ? -1 : 1;
            duration = {
                y: 0,
                d: toInt(match[DATE]) * sign,
                h: toInt(match[HOUR]) * sign,
                m: toInt(match[MINUTE]) * sign,
                s: toInt(match[SECOND]) * sign,
                ms: toInt(match[MILLISECOND]) * sign
            };
        } else if (!!(match = isoDurationRegex.exec(input))) {
            sign = (match[1] === '-') ? -1 : 1;
            parseIso = function (inp) {
                // We'd normally use ~~inp for this, but unfortunately it also
                // converts floats to ints.
                // inp may be undefined, so careful calling replace on it.
                var res = inp && parseFloat(inp.replace(',', '.'));
                // apply sign while we're at it
                return (isNaN(res) ? 0 : res) * sign;
            };
            duration = {
                y: parseIso(match[2]),
                M: parseIso(match[3]),
                d: parseIso(match[4]),
                h: parseIso(match[5]),
                m: parseIso(match[6]),
                s: parseIso(match[7]),
                w: parseIso(match[8])
            };
        } else if (duration == null) {// checks for null or undefined
            duration = {};
        } else if (typeof duration === 'object' &&
                ('from' in duration || 'to' in duration)) {
            diffRes = momentsDifference(moment(duration.from), moment(duration.to));

            duration = {};
            duration.ms = diffRes.milliseconds;
            duration.M = diffRes.months;
        }

        ret = new Duration(duration);

        if (moment.isDuration(input) && hasOwnProp(input, '_locale')) {
            ret._locale = input._locale;
        }

        return ret;
    };

    // version number
    moment.version = VERSION;

    // default format
    moment.defaultFormat = isoFormat;

    // constant that refers to the ISO standard
    moment.ISO_8601 = function () {};

    // Plugins that add properties should also add the key here (null value),
    // so we can properly clone ourselves.
    moment.momentProperties = momentProperties;

    // This function will be called whenever a moment is mutated.
    // It is intended to keep the offset in sync with the timezone.
    moment.updateOffset = function () {};

    // This function allows you to set a threshold for relative time strings
    moment.relativeTimeThreshold = function (threshold, limit) {
        if (relativeTimeThresholds[threshold] === undefined) {
            return false;
        }
        if (limit === undefined) {
            return relativeTimeThresholds[threshold];
        }
        relativeTimeThresholds[threshold] = limit;
        return true;
    };

    moment.lang = deprecate(
            'moment.lang is deprecated. Use moment.locale instead.',
            function (key, value) {
                return moment.locale(key, value);
            }
    );

    // This function will load locale and then set the global locale.  If
    // no arguments are passed in, it will simply return the current global
    // locale key.
    moment.locale = function (key, values) {
        var data;
        if (key) {
            if (typeof (values) !== 'undefined') {
                data = moment.defineLocale(key, values);
            } else {
                data = moment.localeData(key);
            }

            if (data) {
                moment.duration._locale = moment._locale = data;
            }
        }

        return moment._locale._abbr;
    };

    moment.defineLocale = function (name, values) {
        if (values !== null) {
            values.abbr = name;
            if (!locales[name]) {
                locales[name] = new Locale();
            }
            locales[name].set(values);

            // backwards compat for now: also set the locale
            moment.locale(name);

            return locales[name];
        } else {
            // useful for testing
            delete locales[name];
            return null;
        }
    };

    moment.langData = deprecate(
            'moment.langData is deprecated. Use moment.localeData instead.',
            function (key) {
                return moment.localeData(key);
            }
    );

    // returns locale data
    moment.localeData = function (key) {
        var locale;

        if (key && key._locale && key._locale._abbr) {
            key = key._locale._abbr;
        }

        if (!key) {
            return moment._locale;
        }

        if (!isArray(key)) {
            //short-circuit everything else
            locale = loadLocale(key);
            if (locale) {
                return locale;
            }
            key = [key];
        }

        return chooseLocale(key);
    };

    // compare moment object
    moment.isMoment = function (obj) {
        return obj instanceof Moment ||
                (obj != null && hasOwnProp(obj, '_isAMomentObject'));
    };

    // for typechecking Duration objects
    moment.isDuration = function (obj) {
        return obj instanceof Duration;
    };

    for (i = lists.length - 1; i >= 0; --i) {
        makeList(lists[i]);
    }

    moment.normalizeUnits = function (units) {
        return normalizeUnits(units);
    };

    moment.invalid = function (flags) {
        var m = moment.utc(NaN);
        if (flags != null) {
            extend(m._pf, flags);
        } else {
            m._pf.userInvalidated = true;
        }

        return m;
    };

    moment.parseZone = function () {
        return moment.apply(null, arguments).parseZone();
    };

    moment.parseTwoDigitYear = function (input) {
        return toInt(input) + (toInt(input) > 68 ? 1900 : 2000);
    };

    moment.isDate = isDate;

    /************************************
     Moment Prototype
     ************************************/


    extend(moment.fn = Moment.prototype, {

        clone: function () {
            return moment(this);
        },

        valueOf: function () {
            return +this._d - ((this._offset || 0) * 60000);
        },

        unix: function () {
            return Math.floor(+this / 1000);
        },

        toString: function () {
            return this.clone().locale('en').format('ddd MMM DD YYYY HH:mm:ss [GMT]ZZ');
        },

        toDate: function () {
            return this._offset ? new Date(+this) : this._d;
        },

        toISOString: function () {
            var m = moment(this).utc();
            if (0 < m.year() && m.year() <= 9999) {
                if ('function' === typeof Date.prototype.toISOString) {
                    // native implementation is ~50x faster, use it when we can
                    return this.toDate().toISOString();
                } else {
                    return formatMoment(m, 'YYYY-MM-DD[T]HH:mm:ss.SSS[Z]');
                }
            } else {
                return formatMoment(m, 'YYYYYY-MM-DD[T]HH:mm:ss.SSS[Z]');
            }
        },

        toArray: function () {
            var m = this;
            return [
                m.year(),
                m.month(),
                m.date(),
                m.hours(),
                m.minutes(),
                m.seconds(),
                m.milliseconds()
            ];
        },

        isValid: function () {
            return isValid(this);
        },

        isDSTShifted: function () {
            if (this._a) {
                return this.isValid() && compareArrays(this._a, (this._isUTC ? moment.utc(this._a) : moment(this._a)).toArray()) > 0;
            }

            return false;
        },

        parsingFlags: function () {
            return extend({}, this._pf);
        },

        invalidAt: function () {
            return this._pf.overflow;
        },

        utc: function (keepLocalTime) {
            return this.utcOffset(0, keepLocalTime);
        },

        local: function (keepLocalTime) {
            if (this._isUTC) {
                this.utcOffset(0, keepLocalTime);
                this._isUTC = false;

                if (keepLocalTime) {
                    this.subtract(this._dateUtcOffset(), 'm');
                }
            }
            return this;
        },

        format: function (inputString) {
            var output = formatMoment(this, inputString || moment.defaultFormat);
            return this.localeData().postformat(output);
        },

        add: createAdder(1, 'add'),

        subtract: createAdder(-1, 'subtract'),

        diff: function (input, units, asFloat) {
            var that = makeAs(input, this),
                    zoneDiff = (that.utcOffset() - this.utcOffset()) * 6e4,
                    anchor, diff, output, daysAdjust;

            units = normalizeUnits(units);

            if (units === 'year' || units === 'month' || units === 'quarter') {
                output = monthDiff(this, that);
                if (units === 'quarter') {
                    output = output / 3;
                } else if (units === 'year') {
                    output = output / 12;
                }
            } else {
                diff = this - that;
                output = units === 'second' ? diff / 1e3 : // 1000
                        units === 'minute' ? diff / 6e4 : // 1000 * 60
                        units === 'hour' ? diff / 36e5 : // 1000 * 60 * 60
                        units === 'day' ? (diff - zoneDiff) / 864e5 : // 1000 * 60 * 60 * 24, negate dst
                        units === 'week' ? (diff - zoneDiff) / 6048e5 : // 1000 * 60 * 60 * 24 * 7, negate dst
                        diff;
            }
            return asFloat ? output : absRound(output);
        },

        from: function (time, withoutSuffix) {
            return moment.duration({to: this, from: time}).locale(this.locale()).humanize(!withoutSuffix);
        },

        fromNow: function (withoutSuffix) {
            return this.from(moment(), withoutSuffix);
        },

        calendar: function (time) {
            // We want to compare the start of today, vs this.
            // Getting start-of-today depends on whether we're locat/utc/offset
            // or not.
            var now = time || moment(),
                    sod = makeAs(now, this).startOf('day'),
                    diff = this.diff(sod, 'days', true),
                    format = diff < -6 ? 'sameElse' :
                    diff < -1 ? 'lastWeek' :
                    diff < 0 ? 'lastDay' :
                    diff < 1 ? 'sameDay' :
                    diff < 2 ? 'nextDay' :
                    diff < 7 ? 'nextWeek' : 'sameElse';
            return this.format(this.localeData().calendar(format, this, moment(now)));
        },

        isLeapYear: function () {
            return isLeapYear(this.year());
        },

        isDST: function () {
            return (this.utcOffset() > this.clone().month(0).utcOffset() ||
                    this.utcOffset() > this.clone().month(5).utcOffset());
        },

        day: function (input) {
            var day = this._isUTC ? this._d.getUTCDay() : this._d.getDay();
            if (input != null) {
                input = parseWeekday(input, this.localeData());
                return this.add(input - day, 'd');
            } else {
                return day;
            }
        },

        month: makeAccessor('Month', true),

        startOf: function (units) {
            units = normalizeUnits(units);
            // the following switch intentionally omits break keywords
            // to utilize falling through the cases.
            switch (units) {
                case 'year':
                    this.month(0);
                    /* falls through */
                case 'quarter':
                case 'month':
                    this.date(1);
                    /* falls through */
                case 'week':
                case 'isoWeek':
                case 'day':
                    this.hours(0);
                    /* falls through */
                case 'hour':
                    this.minutes(0);
                    /* falls through */
                case 'minute':
                    this.seconds(0);
                    /* falls through */
                case 'second':
                    this.milliseconds(0);
                    /* falls through */
            }

            // weeks are a special case
            if (units === 'week') {
                this.weekday(0);
            } else if (units === 'isoWeek') {
                this.isoWeekday(1);
            }

            // quarters are also special
            if (units === 'quarter') {
                this.month(Math.floor(this.month() / 3) * 3);
            }

            return this;
        },

        endOf: function (units) {
            units = normalizeUnits(units);
            if (units === undefined || units === 'millisecond') {
                return this;
            }
            return this.startOf(units).add(1, (units === 'isoWeek' ? 'week' : units)).subtract(1, 'ms');
        },

        isAfter: function (input, units) {
            var inputMs;
            units = normalizeUnits(typeof units !== 'undefined' ? units : 'millisecond');
            if (units === 'millisecond') {
                input = moment.isMoment(input) ? input : moment(input);
                return +this > +input;
            } else {
                inputMs = moment.isMoment(input) ? +input : +moment(input);
                return inputMs < +this.clone().startOf(units);
            }
        },

        isBefore: function (input, units) {
            var inputMs;
            units = normalizeUnits(typeof units !== 'undefined' ? units : 'millisecond');
            if (units === 'millisecond') {
                input = moment.isMoment(input) ? input : moment(input);
                return +this < +input;
            } else {
                inputMs = moment.isMoment(input) ? +input : +moment(input);
                return +this.clone().endOf(units) < inputMs;
            }
        },

        isBetween: function (from, to, units) {
            return this.isAfter(from, units) && this.isBefore(to, units);
        },

        isSame: function (input, units) {
            var inputMs;
            units = normalizeUnits(units || 'millisecond');
            if (units === 'millisecond') {
                input = moment.isMoment(input) ? input : moment(input);
                return +this === +input;
            } else {
                inputMs = +moment(input);
                return +(this.clone().startOf(units)) <= inputMs && inputMs <= +(this.clone().endOf(units));
            }
        },

        min: deprecate(
                'moment().min is deprecated, use moment.min instead. https://github.com/moment/moment/issues/1548',
                function (other) {
                    other = moment.apply(null, arguments);
                    return other < this ? this : other;
                }
        ),

        max: deprecate(
                'moment().max is deprecated, use moment.max instead. https://github.com/moment/moment/issues/1548',
                function (other) {
                    other = moment.apply(null, arguments);
                    return other > this ? this : other;
                }
        ),

        zone: deprecate(
                'moment().zone is deprecated, use moment().utcOffset instead. ' +
                'https://github.com/moment/moment/issues/1779',
                function (input, keepLocalTime) {
                    if (input != null) {
                        if (typeof input !== 'string') {
                            input = -input;
                        }

                        this.utcOffset(input, keepLocalTime);

                        return this;
                    } else {
                        return -this.utcOffset();
                    }
                }
        ),

        // keepLocalTime = true means only change the timezone, without
        // affecting the local hour. So 5:31:26 +0300 --[utcOffset(2, true)]-->
        // 5:31:26 +0200 It is possible that 5:31:26 doesn't exist with offset
        // +0200, so we adjust the time as needed, to be valid.
        //
        // Keeping the time actually adds/subtracts (one hour)
        // from the actual represented time. That is why we call updateOffset
        // a second time. In case it wants us to change the offset again
        // _changeInProgress == true case, then we have to adjust, because
        // there is no such time in the given timezone.
        utcOffset: function (input, keepLocalTime) {
            var offset = this._offset || 0,
                    localAdjust;
            if (input != null) {
                if (typeof input === 'string') {
                    input = utcOffsetFromString(input);
                }
                if (Math.abs(input) < 16) {
                    input = input * 60;
                }
                if (!this._isUTC && keepLocalTime) {
                    localAdjust = this._dateUtcOffset();
                }
                this._offset = input;
                this._isUTC = true;
                if (localAdjust != null) {
                    this.add(localAdjust, 'm');
                }
                if (offset !== input) {
                    if (!keepLocalTime || this._changeInProgress) {
                        addOrSubtractDurationFromMoment(this,
                                moment.duration(input - offset, 'm'), 1, false);
                    } else if (!this._changeInProgress) {
                        this._changeInProgress = true;
                        moment.updateOffset(this, true);
                        this._changeInProgress = null;
                    }
                }

                return this;
            } else {
                return this._isUTC ? offset : this._dateUtcOffset();
            }
        },

        isLocal: function () {
            return !this._isUTC;
        },

        isUtcOffset: function () {
            return this._isUTC;
        },

        isUtc: function () {
            return this._isUTC && this._offset === 0;
        },

        zoneAbbr: function () {
            return this._isUTC ? 'UTC' : '';
        },

        zoneName: function () {
            return this._isUTC ? 'Coordinated Universal Time' : '';
        },

        parseZone: function () {
            if (this._tzm) {
                this.utcOffset(this._tzm);
            } else if (typeof this._i === 'string') {
                this.utcOffset(utcOffsetFromString(this._i));
            }
            return this;
        },

        hasAlignedHourOffset: function (input) {
            if (!input) {
                input = 0;
            } else {
                input = moment(input).utcOffset();
            }

            return (this.utcOffset() - input) % 60 === 0;
        },

        daysInMonth: function () {
            return daysInMonth(this.year(), this.month());
        },

        dayOfYear: function (input) {
            var dayOfYear = round((moment(this).startOf('day') - moment(this).startOf('year')) / 864e5) + 1;
            return input == null ? dayOfYear : this.add((input - dayOfYear), 'd');
        },

        quarter: function (input) {
            return input == null ? Math.ceil((this.month() + 1) / 3) : this.month((input - 1) * 3 + this.month() % 3);
        },

        weekYear: function (input) {
            var year = weekOfYear(this, this.localeData()._week.dow, this.localeData()._week.doy).year;
            return input == null ? year : this.add((input - year), 'y');
        },

        isoWeekYear: function (input) {
            var year = weekOfYear(this, 1, 4).year;
            return input == null ? year : this.add((input - year), 'y');
        },

        week: function (input) {
            var week = this.localeData().week(this);
            return input == null ? week : this.add((input - week) * 7, 'd');
        },

        isoWeek: function (input) {
            var week = weekOfYear(this, 1, 4).week;
            return input == null ? week : this.add((input - week) * 7, 'd');
        },

        weekday: function (input) {
            var weekday = (this.day() + 7 - this.localeData()._week.dow) % 7;
            return input == null ? weekday : this.add(input - weekday, 'd');
        },

        isoWeekday: function (input) {
            // behaves the same as moment#day except
            // as a getter, returns 7 instead of 0 (1-7 range instead of 0-6)
            // as a setter, sunday should belong to the previous week.
            return input == null ? this.day() || 7 : this.day(this.day() % 7 ? input : input - 7);
        },

        isoWeeksInYear: function () {
            return weeksInYear(this.year(), 1, 4);
        },

        weeksInYear: function () {
            var weekInfo = this.localeData()._week;
            return weeksInYear(this.year(), weekInfo.dow, weekInfo.doy);
        },

        get: function (units) {
            units = normalizeUnits(units);
            return this[units]();
        },

        set: function (units, value) {
            var unit;
            if (typeof units === 'object') {
                for (unit in units) {
                    this.set(unit, units[unit]);
                }
            } else {
                units = normalizeUnits(units);
                if (typeof this[units] === 'function') {
                    this[units](value);
                }
            }
            return this;
        },

        // If passed a locale key, it will set the locale for this
        // instance.  Otherwise, it will return the locale configuration
        // variables for this instance.
        locale: function (key) {
            var newLocaleData;

            if (key === undefined) {
                return this._locale._abbr;
            } else {
                newLocaleData = moment.localeData(key);
                if (newLocaleData != null) {
                    this._locale = newLocaleData;
                }
                return this;
            }
        },

        lang: deprecate(
                'moment().lang() is deprecated. Instead, use moment().localeData() to get the language configuration. Use moment().locale() to change languages.',
                function (key) {
                    if (key === undefined) {
                        return this.localeData();
                    } else {
                        return this.locale(key);
                    }
                }
        ),

        localeData: function () {
            return this._locale;
        },

        _dateUtcOffset: function () {
            // On Firefox.24 Date#getTimezoneOffset returns a floating point.
            // https://github.com/moment/moment/pull/1871
            return -Math.round(this._d.getTimezoneOffset() / 15) * 15;
        }

    });

    function rawMonthSetter(mom, value) {
        var dayOfMonth;

        // TODO: Move this out of here!
        if (typeof value === 'string') {
            value = mom.localeData().monthsParse(value);
            // TODO: Another silent failure?
            if (typeof value !== 'number') {
                return mom;
            }
        }

        dayOfMonth = Math.min(mom.date(),
                daysInMonth(mom.year(), value));
        mom._d['set' + (mom._isUTC ? 'UTC' : '') + 'Month'](value, dayOfMonth);
        return mom;
    }

    function rawGetter(mom, unit) {
        return mom._d['get' + (mom._isUTC ? 'UTC' : '') + unit]();
    }

    function rawSetter(mom, unit, value) {
        if (unit === 'Month') {
            return rawMonthSetter(mom, value);
        } else {
            return mom._d['set' + (mom._isUTC ? 'UTC' : '') + unit](value);
        }
    }

    function makeAccessor(unit, keepTime) {
        return function (value) {
            if (value != null) {
                rawSetter(this, unit, value);
                moment.updateOffset(this, keepTime);
                return this;
            } else {
                return rawGetter(this, unit);
            }
        };
    }

    moment.fn.millisecond = moment.fn.milliseconds = makeAccessor('Milliseconds', false);
    moment.fn.second = moment.fn.seconds = makeAccessor('Seconds', false);
    moment.fn.minute = moment.fn.minutes = makeAccessor('Minutes', false);
    // Setting the hour should keep the time, because the user explicitly
    // specified which hour he wants. So trying to maintain the same hour (in
    // a new timezone) makes sense. Adding/subtracting hours does not follow
    // this rule.
    moment.fn.hour = moment.fn.hours = makeAccessor('Hours', true);
    // moment.fn.month is defined separately
    moment.fn.date = makeAccessor('Date', true);
    moment.fn.dates = deprecate('dates accessor is deprecated. Use date instead.', makeAccessor('Date', true));
    moment.fn.year = makeAccessor('FullYear', true);
    moment.fn.years = deprecate('years accessor is deprecated. Use year instead.', makeAccessor('FullYear', true));

    // add plural methods
    moment.fn.days = moment.fn.day;
    moment.fn.months = moment.fn.month;
    moment.fn.weeks = moment.fn.week;
    moment.fn.isoWeeks = moment.fn.isoWeek;
    moment.fn.quarters = moment.fn.quarter;

    // add aliased format methods
    moment.fn.toJSON = moment.fn.toISOString;

    // alias isUtc for dev-friendliness
    moment.fn.isUTC = moment.fn.isUtc;

    /************************************
     Duration Prototype
     ************************************/


    function daysToYears(days) {
        // 400 years have 146097 days (taking into account leap year rules)
        return days * 400 / 146097;
    }

    function yearsToDays(years) {
        // years * 365 + absRound(years / 4) -
        //     absRound(years / 100) + absRound(years / 400);
        return years * 146097 / 400;
    }

    extend(moment.duration.fn = Duration.prototype, {

        _bubble: function () {
            var milliseconds = this._milliseconds,
                    days = this._days,
                    months = this._months,
                    data = this._data,
                    seconds, minutes, hours, years = 0;

            // The following code bubbles up values, see the tests for
            // examples of what that means.
            data.milliseconds = milliseconds % 1000;

            seconds = absRound(milliseconds / 1000);
            data.seconds = seconds % 60;

            minutes = absRound(seconds / 60);
            data.minutes = minutes % 60;

            hours = absRound(minutes / 60);
            data.hours = hours % 24;

            days += absRound(hours / 24);

            // Accurately convert days to years, assume start from year 0.
            years = absRound(daysToYears(days));
            days -= absRound(yearsToDays(years));

            // 30 days to a month
            // TODO (iskren): Use anchor date (like 1st Jan) to compute this.
            months += absRound(days / 30);
            days %= 30;

            // 12 months -> 1 year
            years += absRound(months / 12);
            months %= 12;

            data.days = days;
            data.months = months;
            data.years = years;
        },

        abs: function () {
            this._milliseconds = Math.abs(this._milliseconds);
            this._days = Math.abs(this._days);
            this._months = Math.abs(this._months);

            this._data.milliseconds = Math.abs(this._data.milliseconds);
            this._data.seconds = Math.abs(this._data.seconds);
            this._data.minutes = Math.abs(this._data.minutes);
            this._data.hours = Math.abs(this._data.hours);
            this._data.months = Math.abs(this._data.months);
            this._data.years = Math.abs(this._data.years);

            return this;
        },

        weeks: function () {
            return absRound(this.days() / 7);
        },

        valueOf: function () {
            return this._milliseconds +
                    this._days * 864e5 +
                    (this._months % 12) * 2592e6 +
                    toInt(this._months / 12) * 31536e6;
        },

        humanize: function (withSuffix) {
            var output = relativeTime(this, !withSuffix, this.localeData());

            if (withSuffix) {
                output = this.localeData().pastFuture(+this, output);
            }

            return this.localeData().postformat(output);
        },

        add: function (input, val) {
            // supports only 2.0-style add(1, 's') or add(moment)
            var dur = moment.duration(input, val);

            this._milliseconds += dur._milliseconds;
            this._days += dur._days;
            this._months += dur._months;

            this._bubble();

            return this;
        },

        subtract: function (input, val) {
            var dur = moment.duration(input, val);

            this._milliseconds -= dur._milliseconds;
            this._days -= dur._days;
            this._months -= dur._months;

            this._bubble();

            return this;
        },

        get: function (units) {
            units = normalizeUnits(units);
            return this[units.toLowerCase() + 's']();
        },

        as: function (units) {
            var days, months;
            units = normalizeUnits(units);

            if (units === 'month' || units === 'year') {
                days = this._days + this._milliseconds / 864e5;
                months = this._months + daysToYears(days) * 12;
                return units === 'month' ? months : months / 12;
            } else {
                // handle milliseconds separately because of floating point math errors (issue #1867)
                days = this._days + Math.round(yearsToDays(this._months / 12));
                switch (units) {
                    case 'week':
                        return days / 7 + this._milliseconds / 6048e5;
                    case 'day':
                        return days + this._milliseconds / 864e5;
                    case 'hour':
                        return days * 24 + this._milliseconds / 36e5;
                    case 'minute':
                        return days * 24 * 60 + this._milliseconds / 6e4;
                    case 'second':
                        return days * 24 * 60 * 60 + this._milliseconds / 1000;
                        // Math.floor prevents floating point math errors here
                    case 'millisecond':
                        return Math.floor(days * 24 * 60 * 60 * 1000) + this._milliseconds;
                    default:
                        throw new Error('Unknown unit ' + units);
                }
            }
        },

        lang: moment.fn.lang,
        locale: moment.fn.locale,

        toIsoString: deprecate(
                'toIsoString() is deprecated. Please use toISOString() instead ' +
                '(notice the capitals)',
                function () {
                    return this.toISOString();
                }
        ),

        toISOString: function () {
            // inspired by https://github.com/dordille/moment-isoduration/blob/master/moment.isoduration.js
            var years = Math.abs(this.years()),
                    months = Math.abs(this.months()),
                    days = Math.abs(this.days()),
                    hours = Math.abs(this.hours()),
                    minutes = Math.abs(this.minutes()),
                    seconds = Math.abs(this.seconds() + this.milliseconds() / 1000);

            if (!this.asSeconds()) {
                // this is the same as C#'s (Noda) and python (isodate)...
                // but not other JS (goog.date)
                return 'P0D';
            }

            return (this.asSeconds() < 0 ? '-' : '') +
                    'P' +
                    (years ? years + 'Y' : '') +
                    (months ? months + 'M' : '') +
                    (days ? days + 'D' : '') +
                    ((hours || minutes || seconds) ? 'T' : '') +
                    (hours ? hours + 'H' : '') +
                    (minutes ? minutes + 'M' : '') +
                    (seconds ? seconds + 'S' : '');
        },

        localeData: function () {
            return this._locale;
        },

        toJSON: function () {
            return this.toISOString();
        }
    });

    moment.duration.fn.toString = moment.duration.fn.toISOString;

    function makeDurationGetter(name) {
        moment.duration.fn[name] = function () {
            return this._data[name];
        };
    }

    for (i in unitMillisecondFactors) {
        if (hasOwnProp(unitMillisecondFactors, i)) {
            makeDurationGetter(i.toLowerCase());
        }
    }

    moment.duration.fn.asMilliseconds = function () {
        return this.as('ms');
    };
    moment.duration.fn.asSeconds = function () {
        return this.as('s');
    };
    moment.duration.fn.asMinutes = function () {
        return this.as('m');
    };
    moment.duration.fn.asHours = function () {
        return this.as('h');
    };
    moment.duration.fn.asDays = function () {
        return this.as('d');
    };
    moment.duration.fn.asWeeks = function () {
        return this.as('weeks');
    };
    moment.duration.fn.asMonths = function () {
        return this.as('M');
    };
    moment.duration.fn.asYears = function () {
        return this.as('y');
    };

    /************************************
     Default Locale
     ************************************/


    // Set default locale, other locale will inherit from English.
    moment.locale('en', {
        ordinalParse: /\d{1,2}(th|st|nd|rd)/,
        ordinal: function (number) {
            var b = number % 10,
                    output = (toInt(number % 100 / 10) === 1) ? 'th' :
                    (b === 1) ? 'st' :
                    (b === 2) ? 'nd' :
                    (b === 3) ? 'rd' : 'th';
            return number + output;
        }
    });

    // moment.js locale configuration
// locale : afrikaans (af)
// author : Werner Mollentze : https://github.com/wernerm

    (function (factory) {
        factory(moment);
    }(function (moment) {
        return moment.defineLocale('af', {
            months: 'Januarie_Februarie_Maart_April_Mei_Junie_Julie_Augustus_September_Oktober_November_Desember'.split('_'),
            monthsShort: 'Jan_Feb_Mar_Apr_Mei_Jun_Jul_Aug_Sep_Okt_Nov_Des'.split('_'),
            weekdays: 'Sondag_Maandag_Dinsdag_Woensdag_Donderdag_Vrydag_Saterdag'.split('_'),
            weekdaysShort: 'Son_Maa_Din_Woe_Don_Vry_Sat'.split('_'),
            weekdaysMin: 'So_Ma_Di_Wo_Do_Vr_Sa'.split('_'),
            meridiemParse: /vm|nm/i,
            isPM: function (input) {
                return /^nm$/i.test(input);
            },
            meridiem: function (hours, minutes, isLower) {
                if (hours < 12) {
                    return isLower ? 'vm' : 'VM';
                } else {
                    return isLower ? 'nm' : 'NM';
                }
            },
            longDateFormat: {
                LT: 'HH:mm',
                LTS: 'LT:ss',
                L: 'DD/MM/YYYY',
                LL: 'D MMMM YYYY',
                LLL: 'D MMMM YYYY LT',
                LLLL: 'dddd, D MMMM YYYY LT'
            },
            calendar: {
                sameDay: '[Vandag om] LT',
                nextDay: '[M??re om] LT',
                nextWeek: 'dddd [om] LT',
                lastDay: '[Gister om] LT',
                lastWeek: '[Laas] dddd [om] LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: 'oor %s',
                past: '%s gelede',
                s: '\'n paar sekondes',
                m: '\'n minuut',
                mm: '%d minute',
                h: '\'n uur',
                hh: '%d ure',
                d: '\'n dag',
                dd: '%d dae',
                M: '\'n maand',
                MM: '%d maande',
                y: '\'n jaar',
                yy: '%d jaar'
            },
            ordinalParse: /\d{1,2}(ste|de)/,
            ordinal: function (number) {
                return number + ((number === 1 || number === 8 || number >= 20) ? 'ste' : 'de'); // Thanks to Joris R??ling : https://github.com/jjupiter
            },
            week: {
                dow: 1, // Maandag is die eerste dag van die week.
                doy: 4  // Die week wat die 4de Januarie bevat is die eerste week van die jaar.
            }
        });
    }));
// moment.js locale configuration
// locale : Moroccan Arabic (ar-ma)
// author : ElFadili Yassine : https://github.com/ElFadiliY
// author : Abdel Said : https://github.com/abdelsaid

    (function (factory) {
        factory(moment);
    }(function (moment) {
        return moment.defineLocale('ar-ma', {
            months: '??????????_????????????_????????_??????????_??????_??????????_????????????_??????_??????????_????????????_??????????_??????????'.split('_'),
            monthsShort: '??????????_????????????_????????_??????????_??????_??????????_????????????_??????_??????????_????????????_??????????_??????????'.split('_'),
            weekdays: '??????????_??????????????_????????????????_????????????????_????????????_????????????_??????????'.split('_'),
            weekdaysShort: '??????_??????????_????????????_????????????_????????_????????_??????'.split('_'),
            weekdaysMin: '??_??_??_??_??_??_??'.split('_'),
            longDateFormat: {
                LT: 'HH:mm',
                LTS: 'LT:ss',
                L: 'DD/MM/YYYY',
                LL: 'D MMMM YYYY',
                LLL: 'D MMMM YYYY LT',
                LLLL: 'dddd D MMMM YYYY LT'
            },
            calendar: {
                sameDay: '[?????????? ?????? ????????????] LT',
                nextDay: '[?????? ?????? ????????????] LT',
                nextWeek: 'dddd [?????? ????????????] LT',
                lastDay: '[?????? ?????? ????????????] LT',
                lastWeek: 'dddd [?????? ????????????] LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: '???? %s',
                past: '?????? %s',
                s: '????????',
                m: '??????????',
                mm: '%d ??????????',
                h: '????????',
                hh: '%d ??????????',
                d: '??????',
                dd: '%d ????????',
                M: '??????',
                MM: '%d ????????',
                y: '??????',
                yy: '%d ??????????'
            },
            week: {
                dow: 6, // Saturday is the first day of the week.
                doy: 12  // The week that contains Jan 1st is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : Arabic Saudi Arabia (ar-sa)
// author : Suhail Alkowaileet : https://github.com/xsoh

    (function (factory) {
        factory(moment);
    }(function (moment) {
        var symbolMap = {
            '1': '??',
            '2': '??',
            '3': '??',
            '4': '??',
            '5': '??',
            '6': '??',
            '7': '??',
            '8': '??',
            '9': '??',
            '0': '??'
        }, numberMap = {
            '??': '1',
            '??': '2',
            '??': '3',
            '??': '4',
            '??': '5',
            '??': '6',
            '??': '7',
            '??': '8',
            '??': '9',
            '??': '0'
        };

        return moment.defineLocale('ar-sa', {
            months: '??????????_????????????_????????_??????????_????????_??????????_??????????_??????????_????????????_????????????_????????????_????????????'.split('_'),
            monthsShort: '??????????_????????????_????????_??????????_????????_??????????_??????????_??????????_????????????_????????????_????????????_????????????'.split('_'),
            weekdays: '??????????_??????????????_????????????????_????????????????_????????????_????????????_??????????'.split('_'),
            weekdaysShort: '??????_??????????_????????????_????????????_????????_????????_??????'.split('_'),
            weekdaysMin: '??_??_??_??_??_??_??'.split('_'),
            longDateFormat: {
                LT: 'HH:mm',
                LTS: 'HH:mm:ss',
                L: 'DD/MM/YYYY',
                LL: 'D MMMM YYYY',
                LLL: 'D MMMM YYYY LT',
                LLLL: 'dddd D MMMM YYYY LT'
            },
            meridiemParse: /??|??/,
            isPM: function (input) {
                return '??' === input;
            },
            meridiem: function (hour, minute, isLower) {
                if (hour < 12) {
                    return '??';
                } else {
                    return '??';
                }
            },
            calendar: {
                sameDay: '[?????????? ?????? ????????????] LT',
                nextDay: '[?????? ?????? ????????????] LT',
                nextWeek: 'dddd [?????? ????????????] LT',
                lastDay: '[?????? ?????? ????????????] LT',
                lastWeek: 'dddd [?????? ????????????] LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: '???? %s',
                past: '?????? %s',
                s: '????????',
                m: '??????????',
                mm: '%d ??????????',
                h: '????????',
                hh: '%d ??????????',
                d: '??????',
                dd: '%d ????????',
                M: '??????',
                MM: '%d ????????',
                y: '??????',
                yy: '%d ??????????'
            },
            preparse: function (string) {
                return string.replace(/[????????????????????]/g, function (match) {
                    return numberMap[match];
                }).replace(/??/g, ',');
            },
            postformat: function (string) {
                return string.replace(/\d/g, function (match) {
                    return symbolMap[match];
                }).replace(/,/g, '??');
            },
            week: {
                dow: 6, // Saturday is the first day of the week.
                doy: 12  // The week that contains Jan 1st is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale  : Tunisian Arabic (ar-tn)

    (function (factory) {
        factory(moment);
    }(function (moment) {
        return moment.defineLocale('ar-tn', {
            months: '??????????_??????????_????????_??????????_??????_????????_????????????_??????_????????????_????????????_????????????_????????????'.split('_'),
            monthsShort: '??????????_??????????_????????_??????????_??????_????????_????????????_??????_????????????_????????????_????????????_????????????'.split('_'),
            weekdays: '??????????_??????????????_????????????????_????????????????_????????????_????????????_??????????'.split('_'),
            weekdaysShort: '??????_??????????_????????????_????????????_????????_????????_??????'.split('_'),
            weekdaysMin: '??_??_??_??_??_??_??'.split('_'),
            longDateFormat: {
                LT: 'HH:mm',
                LTS: 'LT:ss',
                L: 'DD/MM/YYYY',
                LL: 'D MMMM YYYY',
                LLL: 'D MMMM YYYY LT',
                LLLL: 'dddd D MMMM YYYY LT'
            },
            calendar: {
                sameDay: '[?????????? ?????? ????????????] LT',
                nextDay: '[?????? ?????? ????????????] LT',
                nextWeek: 'dddd [?????? ????????????] LT',
                lastDay: '[?????? ?????? ????????????] LT',
                lastWeek: 'dddd [?????? ????????????] LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: '???? %s',
                past: '?????? %s',
                s: '????????',
                m: '??????????',
                mm: '%d ??????????',
                h: '????????',
                hh: '%d ??????????',
                d: '??????',
                dd: '%d ????????',
                M: '??????',
                MM: '%d ????????',
                y: '??????',
                yy: '%d ??????????'
            },
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 4 // The week that contains Jan 4th is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// Locale: Arabic (ar)
// Author: Abdel Said: https://github.com/abdelsaid
// Changes in months, weekdays: Ahmed Elkhatib
// Native plural forms: forabi https://github.com/forabi

    (function (factory) {
        factory(moment);
    }(function (moment) {
        var symbolMap = {
            '1': '??',
            '2': '??',
            '3': '??',
            '4': '??',
            '5': '??',
            '6': '??',
            '7': '??',
            '8': '??',
            '9': '??',
            '0': '??'
        }, numberMap = {
            '??': '1',
            '??': '2',
            '??': '3',
            '??': '4',
            '??': '5',
            '??': '6',
            '??': '7',
            '??': '8',
            '??': '9',
            '??': '0'
        }, pluralForm = function (n) {
            return n === 0 ? 0 : n === 1 ? 1 : n === 2 ? 2 : n % 100 >= 3 && n % 100 <= 10 ? 3 : n % 100 >= 11 ? 4 : 5;
        }, plurals = {
            s: ['?????? ???? ??????????', '?????????? ??????????', ['??????????????', '??????????????'], '%d ????????', '%d ??????????', '%d ??????????'],
            m: ['?????? ???? ??????????', '?????????? ??????????', ['??????????????', '??????????????'], '%d ??????????', '%d ??????????', '%d ??????????'],
            h: ['?????? ???? ????????', '???????? ??????????', ['????????????', '????????????'], '%d ??????????', '%d ????????', '%d ????????'],
            d: ['?????? ???? ??????', '?????? ????????', ['??????????', '??????????'], '%d ????????', '%d ??????????', '%d ??????'],
            M: ['?????? ???? ??????', '?????? ????????', ['??????????', '??????????'], '%d ????????', '%d ????????', '%d ??????'],
            y: ['?????? ???? ??????', '?????? ????????', ['??????????', '??????????'], '%d ??????????', '%d ??????????', '%d ??????']
        }, pluralize = function (u) {
            return function (number, withoutSuffix, string, isFuture) {
                var f = pluralForm(number),
                        str = plurals[u][pluralForm(number)];
                if (f === 2) {
                    str = str[withoutSuffix ? 0 : 1];
                }
                return str.replace(/%d/i, number);
            };
        }, months = [
            '?????????? ???????????? ??????????',
            '???????? ????????????',
            '???????? ????????',
            '?????????? ??????????',
            '???????? ????????',
            '???????????? ??????????',
            '???????? ??????????',
            '???? ??????????',
            '?????????? ????????????',
            '?????????? ?????????? ????????????',
            '?????????? ???????????? ????????????',
            '?????????? ?????????? ????????????'
        ];

        return moment.defineLocale('ar', {
            months: months,
            monthsShort: months,
            weekdays: '??????????_??????????????_????????????????_????????????????_????????????_????????????_??????????'.split('_'),
            weekdaysShort: '??????_??????????_????????????_????????????_????????_????????_??????'.split('_'),
            weekdaysMin: '??_??_??_??_??_??_??'.split('_'),
            longDateFormat: {
                LT: 'HH:mm',
                LTS: 'HH:mm:ss',
                L: 'DD/MM/YYYY',
                LL: 'D MMMM YYYY',
                LLL: 'D MMMM YYYY LT',
                LLLL: 'dddd D MMMM YYYY LT'
            },
            meridiemParse: /??|??/,
            isPM: function (input) {
                return '??' === input;
            },
            meridiem: function (hour, minute, isLower) {
                if (hour < 12) {
                    return '??';
                } else {
                    return '??';
                }
            },
            calendar: {
                sameDay: '[?????????? ?????? ????????????] LT',
                nextDay: '[???????? ?????? ????????????] LT',
                nextWeek: 'dddd [?????? ????????????] LT',
                lastDay: '[?????? ?????? ????????????] LT',
                lastWeek: 'dddd [?????? ????????????] LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: '?????? %s',
                past: '?????? %s',
                s: pluralize('s'),
                m: pluralize('m'),
                mm: pluralize('m'),
                h: pluralize('h'),
                hh: pluralize('h'),
                d: pluralize('d'),
                dd: pluralize('d'),
                M: pluralize('M'),
                MM: pluralize('M'),
                y: pluralize('y'),
                yy: pluralize('y')
            },
            preparse: function (string) {
                return string.replace(/[????????????????????]/g, function (match) {
                    return numberMap[match];
                }).replace(/??/g, ',');
            },
            postformat: function (string) {
                return string.replace(/\d/g, function (match) {
                    return symbolMap[match];
                }).replace(/,/g, '??');
            },
            week: {
                dow: 6, // Saturday is the first day of the week.
                doy: 12  // The week that contains Jan 1st is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : azerbaijani (az)
// author : topchiyev : https://github.com/topchiyev

    (function (factory) {
        factory(moment);
    }(function (moment) {
        var suffixes = {
            1: '-inci',
            5: '-inci',
            8: '-inci',
            70: '-inci',
            80: '-inci',

            2: '-nci',
            7: '-nci',
            20: '-nci',
            50: '-nci',

            3: '-??nc??',
            4: '-??nc??',
            100: '-??nc??',

            6: '-nc??',

            9: '-uncu',
            10: '-uncu',
            30: '-uncu',

            60: '-??nc??',
            90: '-??nc??'
        };
        return moment.defineLocale('az', {
            months: 'yanvar_fevral_mart_aprel_may_iyun_iyul_avqust_sentyabr_oktyabr_noyabr_dekabr'.split('_'),
            monthsShort: 'yan_fev_mar_apr_may_iyn_iyl_avq_sen_okt_noy_dek'.split('_'),
            weekdays: 'Bazar_Bazar ert??si_????r????nb?? ax??am??_????r????nb??_C??m?? ax??am??_C??m??_????nb??'.split('_'),
            weekdaysShort: 'Baz_BzE_??Ax_????r_CAx_C??m_????n'.split('_'),
            weekdaysMin: 'Bz_BE_??A_????_CA_C??_????'.split('_'),
            longDateFormat: {
                LT: 'HH:mm',
                LTS: 'LT:ss',
                L: 'DD.MM.YYYY',
                LL: 'D MMMM YYYY',
                LLL: 'D MMMM YYYY LT',
                LLLL: 'dddd, D MMMM YYYY LT'
            },
            calendar: {
                sameDay: '[bug??n saat] LT',
                nextDay: '[sabah saat] LT',
                nextWeek: '[g??l??n h??ft??] dddd [saat] LT',
                lastDay: '[d??n??n] LT',
                lastWeek: '[ke????n h??ft??] dddd [saat] LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: '%s sonra',
                past: '%s ??vv??l',
                s: 'birne???? saniyy??',
                m: 'bir d??qiq??',
                mm: '%d d??qiq??',
                h: 'bir saat',
                hh: '%d saat',
                d: 'bir g??n',
                dd: '%d g??n',
                M: 'bir ay',
                MM: '%d ay',
                y: 'bir il',
                yy: '%d il'
            },
            meridiemParse: /gec??|s??h??r|g??nd??z|ax??am/,
            isPM: function (input) {
                return /^(g??nd??z|ax??am)$/.test(input);
            },
            meridiem: function (hour, minute, isLower) {
                if (hour < 4) {
                    return 'gec??';
                } else if (hour < 12) {
                    return 's??h??r';
                } else if (hour < 17) {
                    return 'g??nd??z';
                } else {
                    return 'ax??am';
                }
            },
            ordinalParse: /\d{1,2}-(??nc??|inci|nci|??nc??|nc??|uncu)/,
            ordinal: function (number) {
                if (number === 0) {  // special case for zero
                    return number + '-??nc??';
                }
                var a = number % 10,
                        b = number % 100 - a,
                        c = number >= 100 ? 100 : null;

                return number + (suffixes[a] || suffixes[b] || suffixes[c]);
            },
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 7  // The week that contains Jan 1st is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : belarusian (be)
// author : Dmitry Demidov : https://github.com/demidov91
// author: Praleska: http://praleska.pro/
// Author : Menelion Elens??le : https://github.com/Oire

    (function (factory) {
        factory(moment);
    }(function (moment) {
        function plural(word, num) {
            var forms = word.split('_');
            return num % 10 === 1 && num % 100 !== 11 ? forms[0] : (num % 10 >= 2 && num % 10 <= 4 && (num % 100 < 10 || num % 100 >= 20) ? forms[1] : forms[2]);
        }

        function relativeTimeWithPlural(number, withoutSuffix, key) {
            var format = {
                'mm': withoutSuffix ? '??????????????_??????????????_????????????' : '??????????????_??????????????_????????????',
                'hh': withoutSuffix ? '??????????????_??????????????_????????????' : '??????????????_??????????????_????????????',
                'dd': '??????????_??????_????????',
                'MM': '??????????_????????????_??????????????',
                'yy': '??????_????????_??????????'
            };
            if (key === 'm') {
                return withoutSuffix ? '??????????????' : '??????????????';
            } else if (key === 'h') {
                return withoutSuffix ? '??????????????' : '??????????????';
            } else {
                return number + ' ' + plural(format[key], +number);
            }
        }

        function monthsCaseReplace(m, format) {
            var months = {
                'nominative': '????????????????_????????_??????????????_????????????????_??????????????_??????????????_????????????_??????????????_????????????????_????????????????????_????????????????_??????????????'.split('_'),
                'accusative': '????????????????_????????????_????????????????_??????????????????_????????????_??????????????_????????????_????????????_??????????????_??????????????????????_??????????????????_????????????'.split('_')
            },
                    nounCase = (/D[oD]?(\[[^\[\]]*\]|\s+)+MMMM?/).test(format) ?
                    'accusative' :
                    'nominative';

            return months[nounCase][m.month()];
        }

        function weekdaysCaseReplace(m, format) {
            var weekdays = {
                'nominative': '??????????????_????????????????????_??????????????_????????????_????????????_??????????????_????????????'.split('_'),
                'accusative': '??????????????_????????????????????_??????????????_????????????_????????????_??????????????_????????????'.split('_')
            },
                    nounCase = (/\[ ?[????] ?(?:??????????????|??????????????????)? ?\] ?dddd/).test(format) ?
                    'accusative' :
                    'nominative';

            return weekdays[nounCase][m.day()];
        }

        return moment.defineLocale('be', {
            months: monthsCaseReplace,
            monthsShort: '????????_??????_??????_????????_????????_????????_??????_????????_??????_????????_????????_????????'.split('_'),
            weekdays: weekdaysCaseReplace,
            weekdaysShort: '????_????_????_????_????_????_????'.split('_'),
            weekdaysMin: '????_????_????_????_????_????_????'.split('_'),
            longDateFormat: {
                LT: 'HH:mm',
                LTS: 'LT:ss',
                L: 'DD.MM.YYYY',
                LL: 'D MMMM YYYY ??.',
                LLL: 'D MMMM YYYY ??., LT',
                LLLL: 'dddd, D MMMM YYYY ??., LT'
            },
            calendar: {
                sameDay: '[?????????? ??] LT',
                nextDay: '[???????????? ??] LT',
                lastDay: '[?????????? ??] LT',
                nextWeek: function () {
                    return '[??] dddd [??] LT';
                },
                lastWeek: function () {
                    switch (this.day()) {
                        case 0:
                        case 3:
                        case 5:
                        case 6:
                            return '[?? ??????????????] dddd [??] LT';
                        case 1:
                        case 2:
                        case 4:
                            return '[?? ????????????] dddd [??] LT';
                    }
                },
                sameElse: 'L'
            },
            relativeTime: {
                future: '???????? %s',
                past: '%s ????????',
                s: '???????????????? ????????????',
                m: relativeTimeWithPlural,
                mm: relativeTimeWithPlural,
                h: relativeTimeWithPlural,
                hh: relativeTimeWithPlural,
                d: '??????????',
                dd: relativeTimeWithPlural,
                M: '??????????',
                MM: relativeTimeWithPlural,
                y: '??????',
                yy: relativeTimeWithPlural
            },
            meridiemParse: /????????|????????????|??????|????????????/,
            isPM: function (input) {
                return /^(??????|????????????)$/.test(input);
            },
            meridiem: function (hour, minute, isLower) {
                if (hour < 4) {
                    return '????????';
                } else if (hour < 12) {
                    return '????????????';
                } else if (hour < 17) {
                    return '??????';
                } else {
                    return '????????????';
                }
            },

            ordinalParse: /\d{1,2}-(??|??|????)/,
            ordinal: function (number, period) {
                switch (period) {
                    case 'M':
                    case 'd':
                    case 'DDD':
                    case 'w':
                    case 'W':
                        return (number % 10 === 2 || number % 10 === 3) && (number % 100 !== 12 && number % 100 !== 13) ? number + '-??' : number + '-??';
                    case 'D':
                        return number + '-????';
                    default:
                        return number;
                }
            },

            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 7  // The week that contains Jan 1st is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : bulgarian (bg)
// author : Krasen Borisov : https://github.com/kraz

    (function (factory) {
        factory(moment);
    }(function (moment) {
        return moment.defineLocale('bg', {
            months: '????????????_????????????????_????????_??????????_??????_??????_??????_????????????_??????????????????_????????????????_??????????????_????????????????'.split('_'),
            monthsShort: '??????_??????_??????_??????_??????_??????_??????_??????_??????_??????_??????_??????'.split('_'),
            weekdays: '????????????_????????????????????_??????????????_??????????_??????????????????_??????????_????????????'.split('_'),
            weekdaysShort: '??????_??????_??????_??????_??????_??????_??????'.split('_'),
            weekdaysMin: '????_????_????_????_????_????_????'.split('_'),
            longDateFormat: {
                LT: 'H:mm',
                LTS: 'LT:ss',
                L: 'D.MM.YYYY',
                LL: 'D MMMM YYYY',
                LLL: 'D MMMM YYYY LT',
                LLLL: 'dddd, D MMMM YYYY LT'
            },
            calendar: {
                sameDay: '[???????? ??] LT',
                nextDay: '[???????? ??] LT',
                nextWeek: 'dddd [??] LT',
                lastDay: '[?????????? ??] LT',
                lastWeek: function () {
                    switch (this.day()) {
                        case 0:
                        case 3:
                        case 6:
                            return '[?? ????????????????????] dddd [??] LT';
                        case 1:
                        case 2:
                        case 4:
                        case 5:
                            return '[?? ??????????????????] dddd [??] LT';
                    }
                },
                sameElse: 'L'
            },
            relativeTime: {
                future: '???????? %s',
                past: '?????????? %s',
                s: '?????????????? ??????????????',
                m: '????????????',
                mm: '%d ????????????',
                h: '??????',
                hh: '%d ????????',
                d: '??????',
                dd: '%d ??????',
                M: '??????????',
                MM: '%d ????????????',
                y: '????????????',
                yy: '%d ????????????'
            },
            ordinalParse: /\d{1,2}-(????|????|????|????|????|????)/,
            ordinal: function (number) {
                var lastDigit = number % 10,
                        last2Digits = number % 100;
                if (number === 0) {
                    return number + '-????';
                } else if (last2Digits === 0) {
                    return number + '-????';
                } else if (last2Digits > 10 && last2Digits < 20) {
                    return number + '-????';
                } else if (lastDigit === 1) {
                    return number + '-????';
                } else if (lastDigit === 2) {
                    return number + '-????';
                } else if (lastDigit === 7 || lastDigit === 8) {
                    return number + '-????';
                } else {
                    return number + '-????';
                }
            },
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 7  // The week that contains Jan 1st is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : Bengali (bn)
// author : Kaushik Gandhi : https://github.com/kaushikgandhi

    (function (factory) {
        factory(moment);
    }(function (moment) {
        var symbolMap = {
            '1': '???',
            '2': '???',
            '3': '???',
            '4': '???',
            '5': '???',
            '6': '???',
            '7': '???',
            '8': '???',
            '9': '???',
            '0': '???'
        },
                numberMap = {
                    '???': '1',
                    '???': '2',
                    '???': '3',
                    '???': '4',
                    '???': '5',
                    '???': '6',
                    '???': '7',
                    '???': '8',
                    '???': '9',
                    '???': '0'
                };

        return moment.defineLocale('bn', {
            months: '????????????????????????_????????????????????????_???????????????_??????????????????_??????_?????????_???????????????_??????????????????_??????????????????????????????_?????????????????????_?????????????????????_????????????????????????'.split('_'),
            monthsShort: '????????????_?????????_???????????????_?????????_??????_?????????_?????????_??????_???????????????_???????????????_??????_??????????????????'.split('_'),
            weekdays: '??????????????????_??????????????????_????????????????????????_??????????????????_???????????????????????????????????????_???????????????????????????_??????????????????'.split('_'),
            weekdaysShort: '?????????_?????????_???????????????_?????????_??????????????????????????????_??????????????????_?????????'.split('_'),
            weekdaysMin: '??????_??????_????????????_??????_???????????????_??????_?????????'.split('_'),
            longDateFormat: {
                LT: 'A h:mm ?????????',
                LTS: 'A h:mm:ss ?????????',
                L: 'DD/MM/YYYY',
                LL: 'D MMMM YYYY',
                LLL: 'D MMMM YYYY, LT',
                LLLL: 'dddd, D MMMM YYYY, LT'
            },
            calendar: {
                sameDay: '[??????] LT',
                nextDay: '[????????????????????????] LT',
                nextWeek: 'dddd, LT',
                lastDay: '[???????????????] LT',
                lastWeek: '[??????] dddd, LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: '%s ?????????',
                past: '%s ?????????',
                s: '????????? ?????????????????????',
                m: '?????? ???????????????',
                mm: '%d ???????????????',
                h: '?????? ???????????????',
                hh: '%d ???????????????',
                d: '?????? ?????????',
                dd: '%d ?????????',
                M: '?????? ?????????',
                MM: '%d ?????????',
                y: '?????? ?????????',
                yy: '%d ?????????'
            },
            preparse: function (string) {
                return string.replace(/[??????????????????????????????]/g, function (match) {
                    return numberMap[match];
                });
            },
            postformat: function (string) {
                return string.replace(/\d/g, function (match) {
                    return symbolMap[match];
                });
            },
            meridiemParse: /?????????|????????????|???????????????|???????????????|?????????/,
            isPM: function (input) {
                return /^(???????????????|???????????????|?????????)$/.test(input);
            },
            //Bengali is a vast language its spoken
            //in different forms in various parts of the world.
            //I have just generalized with most common one used
            meridiem: function (hour, minute, isLower) {
                if (hour < 4) {
                    return '?????????';
                } else if (hour < 10) {
                    return '????????????';
                } else if (hour < 17) {
                    return '???????????????';
                } else if (hour < 20) {
                    return '???????????????';
                } else {
                    return '?????????';
                }
            },
            week: {
                dow: 0, // Sunday is the first day of the week.
                doy: 6  // The week that contains Jan 1st is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : tibetan (bo)
// author : Thupten N. Chakrishar : https://github.com/vajradog

    (function (factory) {
        factory(moment);
    }(function (moment) {
        var symbolMap = {
            '1': '???',
            '2': '???',
            '3': '???',
            '4': '???',
            '5': '???',
            '6': '???',
            '7': '???',
            '8': '???',
            '9': '???',
            '0': '???'
        },
                numberMap = {
                    '???': '1',
                    '???': '2',
                    '???': '3',
                    '???': '4',
                    '???': '5',
                    '???': '6',
                    '???': '7',
                    '???': '8',
                    '???': '9',
                    '???': '0'
                };

        return moment.defineLocale('bo', {
            months: '??????????????????????????????_?????????????????????????????????_?????????????????????????????????_??????????????????????????????_???????????????????????????_?????????????????????????????????_?????????????????????????????????_????????????????????????????????????_??????????????????????????????_??????????????????????????????_?????????????????????????????????????????????_?????????????????????????????????????????????'.split('_'),
            monthsShort: '??????????????????????????????_?????????????????????????????????_?????????????????????????????????_??????????????????????????????_???????????????????????????_?????????????????????????????????_?????????????????????????????????_????????????????????????????????????_??????????????????????????????_??????????????????????????????_?????????????????????????????????????????????_?????????????????????????????????????????????'.split('_'),
            weekdays: '???????????????????????????_???????????????????????????_????????????????????????????????????_??????????????????????????????_??????????????????????????????_??????????????????????????????_?????????????????????????????????'.split('_'),
            weekdaysShort: '???????????????_???????????????_????????????????????????_??????????????????_??????????????????_??????????????????_?????????????????????'.split('_'),
            weekdaysMin: '???????????????_???????????????_????????????????????????_??????????????????_??????????????????_??????????????????_?????????????????????'.split('_'),
            longDateFormat: {
                LT: 'A h:mm',
                LTS: 'LT:ss',
                L: 'DD/MM/YYYY',
                LL: 'D MMMM YYYY',
                LLL: 'D MMMM YYYY, LT',
                LLLL: 'dddd, D MMMM YYYY, LT'
            },
            calendar: {
                sameDay: '[??????????????????] LT',
                nextDay: '[??????????????????] LT',
                nextWeek: '[?????????????????????????????????????????????], LT',
                lastDay: '[????????????] LT',
                lastWeek: '[??????????????????????????????????????????] dddd, LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: '%s ??????',
                past: '%s ???????????????',
                s: '???????????????',
                m: '??????????????????????????????',
                mm: '%d ???????????????',
                h: '?????????????????????????????????',
                hh: '%d ??????????????????',
                d: '????????????????????????',
                dd: '%d ????????????',
                M: '???????????????????????????',
                MM: '%d ????????????',
                y: '?????????????????????',
                yy: '%d ??????'
            },
            preparse: function (string) {
                return string.replace(/[??????????????????????????????]/g, function (match) {
                    return numberMap[match];
                });
            },
            postformat: function (string) {
                return string.replace(/\d/g, function (match) {
                    return symbolMap[match];
                });
            },
            meridiemParse: /??????????????????|?????????????????????|?????????????????????|?????????????????????|??????????????????/,
            isPM: function (input) {
                return /^(?????????????????????|?????????????????????|??????????????????)$/.test(input);
            },
            meridiem: function (hour, minute, isLower) {
                if (hour < 4) {
                    return '??????????????????';
                } else if (hour < 10) {
                    return '?????????????????????';
                } else if (hour < 17) {
                    return '?????????????????????';
                } else if (hour < 20) {
                    return '?????????????????????';
                } else {
                    return '??????????????????';
                }
            },
            week: {
                dow: 0, // Sunday is the first day of the week.
                doy: 6  // The week that contains Jan 1st is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : breton (br)
// author : Jean-Baptiste Le Duigou : https://github.com/jbleduigou

    (function (factory) {
        factory(moment);
    }(function (moment) {
        function relativeTimeWithMutation(number, withoutSuffix, key) {
            var format = {
                'mm': 'munutenn',
                'MM': 'miz',
                'dd': 'devezh'
            };
            return number + ' ' + mutation(format[key], number);
        }

        function specialMutationForYears(number) {
            switch (lastNumber(number)) {
                case 1:
                case 3:
                case 4:
                case 5:
                case 9:
                    return number + ' bloaz';
                default:
                    return number + ' vloaz';
            }
        }

        function lastNumber(number) {
            if (number > 9) {
                return lastNumber(number % 10);
            }
            return number;
        }

        function mutation(text, number) {
            if (number === 2) {
                return softMutation(text);
            }
            return text;
        }

        function softMutation(text) {
            var mutationTable = {
                'm': 'v',
                'b': 'v',
                'd': 'z'
            };
            if (mutationTable[text.charAt(0)] === undefined) {
                return text;
            }
            return mutationTable[text.charAt(0)] + text.substring(1);
        }

        return moment.defineLocale('br', {
            months: 'Genver_C\'hwevrer_Meurzh_Ebrel_Mae_Mezheven_Gouere_Eost_Gwengolo_Here_Du_Kerzu'.split('_'),
            monthsShort: 'Gen_C\'hwe_Meu_Ebr_Mae_Eve_Gou_Eos_Gwe_Her_Du_Ker'.split('_'),
            weekdays: 'Sul_Lun_Meurzh_Merc\'her_Yaou_Gwener_Sadorn'.split('_'),
            weekdaysShort: 'Sul_Lun_Meu_Mer_Yao_Gwe_Sad'.split('_'),
            weekdaysMin: 'Su_Lu_Me_Mer_Ya_Gw_Sa'.split('_'),
            longDateFormat: {
                LT: 'h[e]mm A',
                LTS: 'h[e]mm:ss A',
                L: 'DD/MM/YYYY',
                LL: 'D [a viz] MMMM YYYY',
                LLL: 'D [a viz] MMMM YYYY LT',
                LLLL: 'dddd, D [a viz] MMMM YYYY LT'
            },
            calendar: {
                sameDay: '[Hiziv da] LT',
                nextDay: '[Warc\'hoazh da] LT',
                nextWeek: 'dddd [da] LT',
                lastDay: '[Dec\'h da] LT',
                lastWeek: 'dddd [paset da] LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: 'a-benn %s',
                past: '%s \'zo',
                s: 'un nebeud segondenno??',
                m: 'ur vunutenn',
                mm: relativeTimeWithMutation,
                h: 'un eur',
                hh: '%d eur',
                d: 'un devezh',
                dd: relativeTimeWithMutation,
                M: 'ur miz',
                MM: relativeTimeWithMutation,
                y: 'ur bloaz',
                yy: specialMutationForYears
            },
            ordinalParse: /\d{1,2}(a??|vet)/,
            ordinal: function (number) {
                var output = (number === 1) ? 'a??' : 'vet';
                return number + output;
            },
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 4  // The week that contains Jan 4th is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : bosnian (bs)
// author : Nedim Cholich : https://github.com/frontyard
// based on (hr) translation by Bojan Markovi??

    (function (factory) {
        factory(moment);
    }(function (moment) {
        function translate(number, withoutSuffix, key) {
            var result = number + ' ';
            switch (key) {
                case 'm':
                    return withoutSuffix ? 'jedna minuta' : 'jedne minute';
                case 'mm':
                    if (number === 1) {
                        result += 'minuta';
                    } else if (number === 2 || number === 3 || number === 4) {
                        result += 'minute';
                    } else {
                        result += 'minuta';
                    }
                    return result;
                case 'h':
                    return withoutSuffix ? 'jedan sat' : 'jednog sata';
                case 'hh':
                    if (number === 1) {
                        result += 'sat';
                    } else if (number === 2 || number === 3 || number === 4) {
                        result += 'sata';
                    } else {
                        result += 'sati';
                    }
                    return result;
                case 'dd':
                    if (number === 1) {
                        result += 'dan';
                    } else {
                        result += 'dana';
                    }
                    return result;
                case 'MM':
                    if (number === 1) {
                        result += 'mjesec';
                    } else if (number === 2 || number === 3 || number === 4) {
                        result += 'mjeseca';
                    } else {
                        result += 'mjeseci';
                    }
                    return result;
                case 'yy':
                    if (number === 1) {
                        result += 'godina';
                    } else if (number === 2 || number === 3 || number === 4) {
                        result += 'godine';
                    } else {
                        result += 'godina';
                    }
                    return result;
            }
        }

        return moment.defineLocale('bs', {
            months: 'januar_februar_mart_april_maj_juni_juli_august_septembar_oktobar_novembar_decembar'.split('_'),
            monthsShort: 'jan._feb._mar._apr._maj._jun._jul._aug._sep._okt._nov._dec.'.split('_'),
            weekdays: 'nedjelja_ponedjeljak_utorak_srijeda_??etvrtak_petak_subota'.split('_'),
            weekdaysShort: 'ned._pon._uto._sri._??et._pet._sub.'.split('_'),
            weekdaysMin: 'ne_po_ut_sr_??e_pe_su'.split('_'),
            longDateFormat: {
                LT: 'H:mm',
                LTS: 'LT:ss',
                L: 'DD. MM. YYYY',
                LL: 'D. MMMM YYYY',
                LLL: 'D. MMMM YYYY LT',
                LLLL: 'dddd, D. MMMM YYYY LT'
            },
            calendar: {
                sameDay: '[danas u] LT',
                nextDay: '[sutra u] LT',

                nextWeek: function () {
                    switch (this.day()) {
                        case 0:
                            return '[u] [nedjelju] [u] LT';
                        case 3:
                            return '[u] [srijedu] [u] LT';
                        case 6:
                            return '[u] [subotu] [u] LT';
                        case 1:
                        case 2:
                        case 4:
                        case 5:
                            return '[u] dddd [u] LT';
                    }
                },
                lastDay: '[ju??er u] LT',
                lastWeek: function () {
                    switch (this.day()) {
                        case 0:
                        case 3:
                            return '[pro??lu] dddd [u] LT';
                        case 6:
                            return '[pro??le] [subote] [u] LT';
                        case 1:
                        case 2:
                        case 4:
                        case 5:
                            return '[pro??li] dddd [u] LT';
                    }
                },
                sameElse: 'L'
            },
            relativeTime: {
                future: 'za %s',
                past: 'prije %s',
                s: 'par sekundi',
                m: translate,
                mm: translate,
                h: translate,
                hh: translate,
                d: 'dan',
                dd: translate,
                M: 'mjesec',
                MM: translate,
                y: 'godinu',
                yy: translate
            },
            ordinalParse: /\d{1,2}\./,
            ordinal: '%d.',
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 7  // The week that contains Jan 1st is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : catalan (ca)
// author : Juan G. Hurtado : https://github.com/juanghurtado

    (function (factory) {
        factory(moment);
    }(function (moment) {
        return moment.defineLocale('ca', {
            months: 'gener_febrer_mar??_abril_maig_juny_juliol_agost_setembre_octubre_novembre_desembre'.split('_'),
            monthsShort: 'gen._febr._mar._abr._mai._jun._jul._ag._set._oct._nov._des.'.split('_'),
            weekdays: 'diumenge_dilluns_dimarts_dimecres_dijous_divendres_dissabte'.split('_'),
            weekdaysShort: 'dg._dl._dt._dc._dj._dv._ds.'.split('_'),
            weekdaysMin: 'Dg_Dl_Dt_Dc_Dj_Dv_Ds'.split('_'),
            longDateFormat: {
                LT: 'H:mm',
                LTS: 'LT:ss',
                L: 'DD/MM/YYYY',
                LL: 'D MMMM YYYY',
                LLL: 'D MMMM YYYY LT',
                LLLL: 'dddd D MMMM YYYY LT'
            },
            calendar: {
                sameDay: function () {
                    return '[avui a ' + ((this.hours() !== 1) ? 'les' : 'la') + '] LT';
                },
                nextDay: function () {
                    return '[dem?? a ' + ((this.hours() !== 1) ? 'les' : 'la') + '] LT';
                },
                nextWeek: function () {
                    return 'dddd [a ' + ((this.hours() !== 1) ? 'les' : 'la') + '] LT';
                },
                lastDay: function () {
                    return '[ahir a ' + ((this.hours() !== 1) ? 'les' : 'la') + '] LT';
                },
                lastWeek: function () {
                    return '[el] dddd [passat a ' + ((this.hours() !== 1) ? 'les' : 'la') + '] LT';
                },
                sameElse: 'L'
            },
            relativeTime: {
                future: 'en %s',
                past: 'fa %s',
                s: 'uns segons',
                m: 'un minut',
                mm: '%d minuts',
                h: 'una hora',
                hh: '%d hores',
                d: 'un dia',
                dd: '%d dies',
                M: 'un mes',
                MM: '%d mesos',
                y: 'un any',
                yy: '%d anys'
            },
            ordinalParse: /\d{1,2}(r|n|t|??|a)/,
            ordinal: function (number, period) {
                var output = (number === 1) ? 'r' :
                        (number === 2) ? 'n' :
                        (number === 3) ? 'r' :
                        (number === 4) ? 't' : '??';
                if (period === 'w' || period === 'W') {
                    output = 'a';
                }
                return number + output;
            },
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 4  // The week that contains Jan 4th is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : czech (cs)
// author : petrbela : https://github.com/petrbela

    (function (factory) {
        factory(moment);
    }(function (moment) {
        var months = 'leden_??nor_b??ezen_duben_kv??ten_??erven_??ervenec_srpen_z??????_????jen_listopadsinec'.split('_'),
                monthsShort = 'led_??no_b??e_dub_kv??_??vn_??vc_srp_z????_????j_lis'.split('_');

        function plural(n) {
            return (n > 1) && (n < 5) && (~~(n / 10) !== 1);
        }

        function translate(number, withoutSuffix, key, isFuture) {
            var result = number + ' ';
            switch (key) {
                case 's':  // a few seconds / in a few seconds / a few seconds ago
                    return (withoutSuffix || isFuture) ? 'p??r sekund' : 'p??r sekundami';
                case 'm':  // a minute / in a minute / a minute ago
                    return withoutSuffix ? 'minuta' : (isFuture ? 'minutu' : 'minutou');
                case 'mm': // 9 minutes / in 9 minutes / 9 minutes ago
                    if (withoutSuffix || isFuture) {
                        return result + (plural(number) ? 'minuty' : 'minut');
                    } else {
                        return result + 'minutami';
                    }
                    break;
                case 'h':  // an hour / in an hour / an hour ago
                    return withoutSuffix ? 'hodina' : (isFuture ? 'hodinu' : 'hodinou');
                case 'hh': // 9 hours / in 9 hours / 9 hours ago
                    if (withoutSuffix || isFuture) {
                        return result + (plural(number) ? 'hodiny' : 'hodin');
                    } else {
                        return result + 'hodinami';
                    }
                    break;
                case 'd':  // a day / in a day / a day ago
                    return (withoutSuffix || isFuture) ? 'den' : 'dnem';
                case 'dd': // 9 days / in 9 days / 9 days ago
                    if (withoutSuffix || isFuture) {
                        return result + (plural(number) ? 'dny' : 'dn??');
                    } else {
                        return result + 'dny';
                    }
                    break;
                case 'M':  // a month / in a month / a month ago
                    return (withoutSuffix || isFuture) ? 'm??s??c' : 'm??s??cem';
                case 'MM': // 9 months / in 9 months / 9 months ago
                    if (withoutSuffix || isFuture) {
                        return result + (plural(number) ? 'm??s??ce' : 'm??s??c??');
                    } else {
                        return result + 'm??s??ci';
                    }
                    break;
                case 'y':  // a year / in a year / a year ago
                    return (withoutSuffix || isFuture) ? 'rok' : 'rokem';
                case 'yy': // 9 years / in 9 years / 9 years ago
                    if (withoutSuffix || isFuture) {
                        return result + (plural(number) ? 'roky' : 'let');
                    } else {
                        return result + 'lety';
                    }
                    break;
            }
        }

        return moment.defineLocale('cs', {
            months: months,
            monthsShort: monthsShort,
            monthsParse: (function (months, monthsShort) {
                var i, _monthsParse = [];
                for (i = 0; i < 12; i++) {
                    // use custom parser to solve problem with July (??ervenec)
                    _monthsParse[i] = new RegExp('^' + months[i] + '$|^' + monthsShort[i] + '$', 'i');
                }
                return _monthsParse;
            }(months, monthsShort)),
            weekdays: 'ned??le_pond??l??_??ter??_st??eda_??tvrtek_p??tek_sobota'.split('_'),
            weekdaysShort: 'ne_po_??t_st_??t_p??_so'.split('_'),
            weekdaysMin: 'ne_po_??t_st_??t_p??_so'.split('_'),
            longDateFormat: {
                LT: 'H:mm',
                LTS: 'LT:ss',
                L: 'DD.MM.YYYY',
                LL: 'D. MMMM YYYY',
                LLL: 'D. MMMM YYYY LT',
                LLLL: 'dddd D. MMMM YYYY LT'
            },
            calendar: {
                sameDay: '[dnes v] LT',
                nextDay: '[z??tra v] LT',
                nextWeek: function () {
                    switch (this.day()) {
                        case 0:
                            return '[v ned??li v] LT';
                        case 1:
                        case 2:
                            return '[v] dddd [v] LT';
                        case 3:
                            return '[ve st??edu v] LT';
                        case 4:
                            return '[ve ??tvrtek v] LT';
                        case 5:
                            return '[v p??tek v] LT';
                        case 6:
                            return '[v sobotu v] LT';
                    }
                },
                lastDay: '[v??era v] LT',
                lastWeek: function () {
                    switch (this.day()) {
                        case 0:
                            return '[minulou ned??li v] LT';
                        case 1:
                        case 2:
                            return '[minul??] dddd [v] LT';
                        case 3:
                            return '[minulou st??edu v] LT';
                        case 4:
                        case 5:
                            return '[minul??] dddd [v] LT';
                        case 6:
                            return '[minulou sobotu v] LT';
                    }
                },
                sameElse: 'L'
            },
            relativeTime: {
                future: 'za %s',
                past: 'p??ed %s',
                s: translate,
                m: translate,
                mm: translate,
                h: translate,
                hh: translate,
                d: translate,
                dd: translate,
                M: translate,
                MM: translate,
                y: translate,
                yy: translate
            },
            ordinalParse: /\d{1,2}\./,
            ordinal: '%d.',
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 4  // The week that contains Jan 4th is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : chuvash (cv)
// author : Anatoly Mironov : https://github.com/mirontoli

    (function (factory) {
        factory(moment);
    }(function (moment) {
        return moment.defineLocale('cv', {
            months: '????????????_??????????_??????_??????_??????_????????????_??????_??????????_????????_??????_??????_????????????'.split('_'),
            monthsShort: '??????_??????_??????_??????_??????_??????_??????_??????_????_??????_??????_??????'.split('_'),
            weekdays: '??????????????????????_????????????????_??????????????????_??????????_??????????????????????_??????????????_????????????????'.split('_'),
            weekdaysShort: '??????_??????_??????_????_??????_??????_??????'.split('_'),
            weekdaysMin: '????_????_????_????_????_????_????'.split('_'),
            longDateFormat: {
                LT: 'HH:mm',
                LTS: 'LT:ss',
                L: 'DD-MM-YYYY',
                LL: 'YYYY [??????????] MMMM [????????????] D[-????????]',
                LLL: 'YYYY [??????????] MMMM [????????????] D[-????????], LT',
                LLLL: 'dddd, YYYY [??????????] MMMM [????????????] D[-????????], LT'
            },
            calendar: {
                sameDay: '[????????] LT [??????????????]',
                nextDay: '[????????] LT [??????????????]',
                lastDay: '[????????] LT [??????????????]',
                nextWeek: '[??????????] dddd LT [??????????????]',
                lastWeek: '[??????????] dddd LT [??????????????]',
                sameElse: 'L'
            },
            relativeTime: {
                future: function (output) {
                    var affix = /??????????$/i.exec(output) ? '??????' : /??????$/i.exec(output) ? '??????' : '??????';
                    return output + affix;
                },
                past: '%s ????????????',
                s: '??????-???? ??????????????',
                m: '?????? ??????????',
                mm: '%d ??????????',
                h: '?????? ??????????',
                hh: '%d ??????????',
                d: '?????? ??????',
                dd: '%d ??????',
                M: '?????? ????????',
                MM: '%d ????????',
                y: '?????? ??????',
                yy: '%d ??????'
            },
            ordinalParse: /\d{1,2}-??????/,
            ordinal: '%d-??????',
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 7  // The week that contains Jan 1st is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : Welsh (cy)
// author : Robert Allen

    (function (factory) {
        factory(moment);
    }(function (moment) {
        return moment.defineLocale('cy', {
            months: 'Ionawr_Chwefror_Mawrth_Ebrill_Mai_Mehefin_Gorffennaf_Awst_Medi_Hydref_Tachwedd_Rhagfyr'.split('_'),
            monthsShort: 'Ion_Chwe_Maw_Ebr_Mai_Meh_Gor_Aws_Med_Hyd_Tach_Rhag'.split('_'),
            weekdays: 'Dydd Sul_Dydd Llun_Dydd Mawrth_Dydd Mercher_Dydd Iau_Dydd Gwener_Dydd Sadwrn'.split('_'),
            weekdaysShort: 'Sul_Llun_Maw_Mer_Iau_Gwe_Sad'.split('_'),
            weekdaysMin: 'Su_Ll_Ma_Me_Ia_Gw_Sa'.split('_'),
            // time formats are the same as en-gb
            longDateFormat: {
                LT: 'HH:mm',
                LTS: 'LT:ss',
                L: 'DD/MM/YYYY',
                LL: 'D MMMM YYYY',
                LLL: 'D MMMM YYYY LT',
                LLLL: 'dddd, D MMMM YYYY LT'
            },
            calendar: {
                sameDay: '[Heddiw am] LT',
                nextDay: '[Yfory am] LT',
                nextWeek: 'dddd [am] LT',
                lastDay: '[Ddoe am] LT',
                lastWeek: 'dddd [diwethaf am] LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: 'mewn %s',
                past: '%s yn ??l',
                s: 'ychydig eiliadau',
                m: 'munud',
                mm: '%d munud',
                h: 'awr',
                hh: '%d awr',
                d: 'diwrnod',
                dd: '%d diwrnod',
                M: 'mis',
                MM: '%d mis',
                y: 'blwyddyn',
                yy: '%d flynedd'
            },
            ordinalParse: /\d{1,2}(fed|ain|af|il|ydd|ed|eg)/,
            // traditional ordinal numbers above 31 are not commonly used in colloquial Welsh
            ordinal: function (number) {
                var b = number,
                        output = '',
                        lookup = [
                            '', 'af', 'il', 'ydd', 'ydd', 'ed', 'ed', 'ed', 'fed', 'fed', 'fed', // 1af to 10fed
                            'eg', 'fed', 'eg', 'eg', 'fed', 'eg', 'eg', 'fed', 'eg', 'fed' // 11eg to 20fed
                        ];

                if (b > 20) {
                    if (b === 40 || b === 50 || b === 60 || b === 80 || b === 100) {
                        output = 'fed'; // not 30ain, 70ain or 90ain
                    } else {
                        output = 'ain';
                    }
                } else if (b > 0) {
                    output = lookup[b];
                }

                return number + output;
            },
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 4  // The week that contains Jan 4th is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : danish (da)
// author : Ulrik Nielsen : https://github.com/mrbase

    (function (factory) {
        factory(moment);
    }(function (moment) {
        return moment.defineLocale('da', {
            months: 'januar_februar_marts_april_maj_juni_juli_august_september_oktober_november_december'.split('_'),
            monthsShort: 'jan_feb_mar_apr_maj_jun_jul_aug_sep_okt_nov_dec'.split('_'),
            weekdays: 's??ndag_mandag_tirsdag_onsdag_torsdag_fredag_l??rdag'.split('_'),
            weekdaysShort: 's??n_man_tir_ons_tor_fre_l??r'.split('_'),
            weekdaysMin: 's??_ma_ti_on_to_fr_l??'.split('_'),
            longDateFormat: {
                LT: 'HH:mm',
                LTS: 'LT:ss',
                L: 'DD/MM/YYYY',
                LL: 'D. MMMM YYYY',
                LLL: 'D. MMMM YYYY LT',
                LLLL: 'dddd [d.] D. MMMM YYYY LT'
            },
            calendar: {
                sameDay: '[I dag kl.] LT',
                nextDay: '[I morgen kl.] LT',
                nextWeek: 'dddd [kl.] LT',
                lastDay: '[I g??r kl.] LT',
                lastWeek: '[sidste] dddd [kl] LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: 'om %s',
                past: '%s siden',
                s: 'f?? sekunder',
                m: 'et minut',
                mm: '%d minutter',
                h: 'en time',
                hh: '%d timer',
                d: 'en dag',
                dd: '%d dage',
                M: 'en m??ned',
                MM: '%d m??neder',
                y: 'et ??r',
                yy: '%d ??r'
            },
            ordinalParse: /\d{1,2}\./,
            ordinal: '%d.',
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 4  // The week that contains Jan 4th is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : austrian german (de-at)
// author : lluchs : https://github.com/lluchs
// author: Menelion Elens??le: https://github.com/Oire
// author : Martin Groller : https://github.com/MadMG

    (function (factory) {
        factory(moment);
    }(function (moment) {
        function processRelativeTime(number, withoutSuffix, key, isFuture) {
            var format = {
                'm': ['eine Minute', 'einer Minute'],
                'h': ['eine Stunde', 'einer Stunde'],
                'd': ['ein Tag', 'einem Tag'],
                'dd': [number + ' Tage', number + ' Tagen'],
                'M': ['ein Monat', 'einem Monat'],
                'MM': [number + ' Monate', number + ' Monaten'],
                'y': ['ein Jahr', 'einem Jahr'],
                'yy': [number + ' Jahre', number + ' Jahren']
            };
            return withoutSuffix ? format[key][0] : format[key][1];
        }

        return moment.defineLocale('de-at', {
            months: 'J??nner_Februar_M??rz_April_Mai_Juni_Juli_August_September_Oktober_November_Dezember'.split('_'),
            monthsShort: 'J??n._Febr._Mrz._Apr._Mai_Jun._Jul._Aug._Sept._Okt._Nov._Dez.'.split('_'),
            weekdays: 'Sonntag_Montag_Dienstag_Mittwoch_Donnerstag_Freitag_Samstag'.split('_'),
            weekdaysShort: 'So._Mo._Di._Mi._Do._Fr._Sa.'.split('_'),
            weekdaysMin: 'So_Mo_Di_Mi_Do_Fr_Sa'.split('_'),
            longDateFormat: {
                LT: 'HH:mm',
                LTS: 'HH:mm:ss',
                L: 'DD.MM.YYYY',
                LL: 'D. MMMM YYYY',
                LLL: 'D. MMMM YYYY LT',
                LLLL: 'dddd, D. MMMM YYYY LT'
            },
            calendar: {
                sameDay: '[Heute um] LT [Uhr]',
                sameElse: 'L',
                nextDay: '[Morgen um] LT [Uhr]',
                nextWeek: 'dddd [um] LT [Uhr]',
                lastDay: '[Gestern um] LT [Uhr]',
                lastWeek: '[letzten] dddd [um] LT [Uhr]'
            },
            relativeTime: {
                future: 'in %s',
                past: 'vor %s',
                s: 'ein paar Sekunden',
                m: processRelativeTime,
                mm: '%d Minuten',
                h: processRelativeTime,
                hh: '%d Stunden',
                d: processRelativeTime,
                dd: processRelativeTime,
                M: processRelativeTime,
                MM: processRelativeTime,
                y: processRelativeTime,
                yy: processRelativeTime
            },
            ordinalParse: /\d{1,2}\./,
            ordinal: '%d.',
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 4  // The week that contains Jan 4th is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : german (de)
// author : lluchs : https://github.com/lluchs
// author: Menelion Elens??le: https://github.com/Oire

    (function (factory) {
        factory(moment);
    }(function (moment) {
        function processRelativeTime(number, withoutSuffix, key, isFuture) {
            var format = {
                'm': ['eine Minute', 'einer Minute'],
                'h': ['eine Stunde', 'einer Stunde'],
                'd': ['ein Tag', 'einem Tag'],
                'dd': [number + ' Tage', number + ' Tagen'],
                'M': ['ein Monat', 'einem Monat'],
                'MM': [number + ' Monate', number + ' Monaten'],
                'y': ['ein Jahr', 'einem Jahr'],
                'yy': [number + ' Jahre', number + ' Jahren']
            };
            return withoutSuffix ? format[key][0] : format[key][1];
        }

        return moment.defineLocale('de', {
            months: 'Januar_Februar_M??rz_April_Mai_Juni_Juli_August_September_Oktober_November_Dezember'.split('_'),
            monthsShort: 'Jan._Febr._Mrz._Apr._Mai_Jun._Jul._Aug._Sept._Okt._Nov._Dez.'.split('_'),
            weekdays: 'Sonntag_Montag_Dienstag_Mittwoch_Donnerstag_Freitag_Samstag'.split('_'),
            weekdaysShort: 'So._Mo._Di._Mi._Do._Fr._Sa.'.split('_'),
            weekdaysMin: 'So_Mo_Di_Mi_Do_Fr_Sa'.split('_'),
            longDateFormat: {
                LT: 'HH:mm',
                LTS: 'HH:mm:ss',
                L: 'DD.MM.YYYY',
                LL: 'D. MMMM YYYY',
                LLL: 'D. MMMM YYYY LT',
                LLLL: 'dddd, D. MMMM YYYY LT'
            },
            calendar: {
                sameDay: '[Heute um] LT [Uhr]',
                sameElse: 'L',
                nextDay: '[Morgen um] LT [Uhr]',
                nextWeek: 'dddd [um] LT [Uhr]',
                lastDay: '[Gestern um] LT [Uhr]',
                lastWeek: '[letzten] dddd [um] LT [Uhr]'
            },
            relativeTime: {
                future: 'in %s',
                past: 'vor %s',
                s: 'ein paar Sekunden',
                m: processRelativeTime,
                mm: '%d Minuten',
                h: processRelativeTime,
                hh: '%d Stunden',
                d: processRelativeTime,
                dd: processRelativeTime,
                M: processRelativeTime,
                MM: processRelativeTime,
                y: processRelativeTime,
                yy: processRelativeTime
            },
            ordinalParse: /\d{1,2}\./,
            ordinal: '%d.',
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 4  // The week that contains Jan 4th is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : modern greek (el)
// author : Aggelos Karalias : https://github.com/mehiel

    (function (factory) {
        factory(moment);
    }(function (moment) {
        return moment.defineLocale('el', {
            monthsNominativeEl: '????????????????????_??????????????????????_??????????????_????????????????_??????????_??????????????_??????????????_??????????????????_??????????????????????_??????????????????_??????????????????_????????????????????'.split('_'),
            monthsGenitiveEl: '????????????????????_??????????????????????_??????????????_????????????????_??????????_??????????????_??????????????_??????????????????_??????????????????????_??????????????????_??????????????????_????????????????????'.split('_'),
            months: function (momentToFormat, format) {
                if (/D/.test(format.substring(0, format.indexOf('MMMM')))) { // if there is a day number before 'MMMM'
                    return this._monthsGenitiveEl[momentToFormat.month()];
                } else {
                    return this._monthsNominativeEl[momentToFormat.month()];
                }
            },
            monthsShort: '??????_??????_??????_??????_??????_????????_????????_??????_??????_??????_??????_??????'.split('_'),
            weekdays: '??????????????_??????????????_??????????_??????????????_????????????_??????????????????_??????????????'.split('_'),
            weekdaysShort: '??????_??????_??????_??????_??????_??????_??????'.split('_'),
            weekdaysMin: '????_????_????_????_????_????_????'.split('_'),
            meridiem: function (hours, minutes, isLower) {
                if (hours > 11) {
                    return isLower ? '????' : '????';
                } else {
                    return isLower ? '????' : '????';
                }
            },
            isPM: function (input) {
                return ((input + '').toLowerCase()[0] === '??');
            },
            meridiemParse: /[????]\.????\.?/i,
            longDateFormat: {
                LT: 'h:mm A',
                LTS: 'h:mm:ss A',
                L: 'DD/MM/YYYY',
                LL: 'D MMMM YYYY',
                LLL: 'D MMMM YYYY LT',
                LLLL: 'dddd, D MMMM YYYY LT'
            },
            calendarEl: {
                sameDay: '[???????????? {}] LT',
                nextDay: '[?????????? {}] LT',
                nextWeek: 'dddd [{}] LT',
                lastDay: '[???????? {}] LT',
                lastWeek: function () {
                    switch (this.day()) {
                        case 6:
                            return '[???? ??????????????????????] dddd [{}] LT';
                        default:
                            return '[?????? ??????????????????????] dddd [{}] LT';
                    }
                },
                sameElse: 'L'
            },
            calendar: function (key, mom) {
                var output = this._calendarEl[key],
                        hours = mom && mom.hours();

                if (typeof output === 'function') {
                    output = output.apply(mom);
                }

                return output.replace('{}', (hours % 12 === 1 ? '??????' : '????????'));
            },
            relativeTime: {
                future: '???? %s',
                past: '%s ????????',
                s: '???????? ????????????????????????',
                m: '?????? ??????????',
                mm: '%d ??????????',
                h: '?????? ??????',
                hh: '%d ????????',
                d: '?????? ????????',
                dd: '%d ??????????',
                M: '???????? ??????????',
                MM: '%d ??????????',
                y: '???????? ????????????',
                yy: '%d ????????????'
            },
            ordinalParse: /\d{1,2}??/,
            ordinal: '%d??',
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 4  // The week that contains Jan 4st is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : australian english (en-au)

    (function (factory) {
        factory(moment);
    }(function (moment) {
        return moment.defineLocale('en-au', {
            months: 'January_February_March_April_May_June_July_August_September_October_November_December'.split('_'),
            monthsShort: 'Jan_Feb_Mar_Apr_May_Jun_Jul_Aug_Sep_Oct_Nov_Dec'.split('_'),
            weekdays: 'Sunday_Monday_Tuesday_Wednesday_Thursday_Friday_Saturday'.split('_'),
            weekdaysShort: 'Sun_Mon_Tue_Wed_Thu_Fri_Sat'.split('_'),
            weekdaysMin: 'Su_Mo_Tu_We_Th_Fr_Sa'.split('_'),
            longDateFormat: {
                LT: 'h:mm A',
                LTS: 'h:mm:ss A',
                L: 'DD/MM/YYYY',
                LL: 'D MMMM YYYY',
                LLL: 'D MMMM YYYY LT',
                LLLL: 'dddd, D MMMM YYYY LT'
            },
            calendar: {
                sameDay: '[Today at] LT',
                nextDay: '[Tomorrow at] LT',
                nextWeek: 'dddd [at] LT',
                lastDay: '[Yesterday at] LT',
                lastWeek: '[Last] dddd [at] LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: 'in %s',
                past: '%s ago',
                s: 'a few seconds',
                m: 'a minute',
                mm: '%d minutes',
                h: 'an hour',
                hh: '%d hours',
                d: 'a day',
                dd: '%d days',
                M: 'a month',
                MM: '%d months',
                y: 'a year',
                yy: '%d years'
            },
            ordinalParse: /\d{1,2}(st|nd|rd|th)/,
            ordinal: function (number) {
                var b = number % 10,
                        output = (~~(number % 100 / 10) === 1) ? 'th' :
                        (b === 1) ? 'st' :
                        (b === 2) ? 'nd' :
                        (b === 3) ? 'rd' : 'th';
                return number + output;
            },
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 4  // The week that contains Jan 4th is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : canadian english (en-ca)
// author : Jonathan Abourbih : https://github.com/jonbca

    (function (factory) {
        factory(moment);
    }(function (moment) {
        return moment.defineLocale('en-ca', {
            months: 'January_February_March_April_May_June_July_August_September_October_November_December'.split('_'),
            monthsShort: 'Jan_Feb_Mar_Apr_May_Jun_Jul_Aug_Sep_Oct_Nov_Dec'.split('_'),
            weekdays: 'Sunday_Monday_Tuesday_Wednesday_Thursday_Friday_Saturday'.split('_'),
            weekdaysShort: 'Sun_Mon_Tue_Wed_Thu_Fri_Sat'.split('_'),
            weekdaysMin: 'Su_Mo_Tu_We_Th_Fr_Sa'.split('_'),
            longDateFormat: {
                LT: 'h:mm A',
                LTS: 'h:mm:ss A',
                L: 'YYYY-MM-DD',
                LL: 'D MMMM, YYYY',
                LLL: 'D MMMM, YYYY LT',
                LLLL: 'dddd, D MMMM, YYYY LT'
            },
            calendar: {
                sameDay: '[Today at] LT',
                nextDay: '[Tomorrow at] LT',
                nextWeek: 'dddd [at] LT',
                lastDay: '[Yesterday at] LT',
                lastWeek: '[Last] dddd [at] LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: 'in %s',
                past: '%s ago',
                s: 'a few seconds',
                m: 'a minute',
                mm: '%d minutes',
                h: 'an hour',
                hh: '%d hours',
                d: 'a day',
                dd: '%d days',
                M: 'a month',
                MM: '%d months',
                y: 'a year',
                yy: '%d years'
            },
            ordinalParse: /\d{1,2}(st|nd|rd|th)/,
            ordinal: function (number) {
                var b = number % 10,
                        output = (~~(number % 100 / 10) === 1) ? 'th' :
                        (b === 1) ? 'st' :
                        (b === 2) ? 'nd' :
                        (b === 3) ? 'rd' : 'th';
                return number + output;
            }
        });
    }));
// moment.js locale configuration
// locale : great britain english (en-gb)
// author : Chris Gedrim : https://github.com/chrisgedrim

    (function (factory) {
        factory(moment);
    }(function (moment) {
        return moment.defineLocale('en-gb', {
            months: 'January_February_March_April_May_June_July_August_September_October_November_December'.split('_'),
            monthsShort: 'Jan_Feb_Mar_Apr_May_Jun_Jul_Aug_Sep_Oct_Nov_Dec'.split('_'),
            weekdays: 'Sunday_Monday_Tuesday_Wednesday_Thursday_Friday_Saturday'.split('_'),
            weekdaysShort: 'Sun_Mon_Tue_Wed_Thu_Fri_Sat'.split('_'),
            weekdaysMin: 'Su_Mo_Tu_We_Th_Fr_Sa'.split('_'),
            longDateFormat: {
                LT: 'HH:mm',
                LTS: 'HH:mm:ss',
                L: 'DD/MM/YYYY',
                LL: 'D MMMM YYYY',
                LLL: 'D MMMM YYYY LT',
                LLLL: 'dddd, D MMMM YYYY LT'
            },
            calendar: {
                sameDay: '[Today at] LT',
                nextDay: '[Tomorrow at] LT',
                nextWeek: 'dddd [at] LT',
                lastDay: '[Yesterday at] LT',
                lastWeek: '[Last] dddd [at] LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: 'in %s',
                past: '%s ago',
                s: 'a few seconds',
                m: 'a minute',
                mm: '%d minutes',
                h: 'an hour',
                hh: '%d hours',
                d: 'a day',
                dd: '%d days',
                M: 'a month',
                MM: '%d months',
                y: 'a year',
                yy: '%d years'
            },
            ordinalParse: /\d{1,2}(st|nd|rd|th)/,
            ordinal: function (number) {
                var b = number % 10,
                        output = (~~(number % 100 / 10) === 1) ? 'th' :
                        (b === 1) ? 'st' :
                        (b === 2) ? 'nd' :
                        (b === 3) ? 'rd' : 'th';
                return number + output;
            },
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 4  // The week that contains Jan 4th is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : esperanto (eo)
// author : Colin Dean : https://github.com/colindean
// komento: Mi estas malcerta se mi korekte traktis akuzativojn en tiu traduko.
//          Se ne, bonvolu korekti kaj avizi min por ke mi povas lerni!

    (function (factory) {
        factory(moment);
    }(function (moment) {
        return moment.defineLocale('eo', {
            months: 'januaro_februaro_marto_aprilo_majo_junio_julio_a??gusto_septembro_oktobro_novembro_decembro'.split('_'),
            monthsShort: 'jan_feb_mar_apr_maj_jun_jul_a??g_sep_okt_nov_dec'.split('_'),
            weekdays: 'Diman??o_Lundo_Mardo_Merkredo_??a??do_Vendredo_Sabato'.split('_'),
            weekdaysShort: 'Dim_Lun_Mard_Merk_??a??_Ven_Sab'.split('_'),
            weekdaysMin: 'Di_Lu_Ma_Me_??a_Ve_Sa'.split('_'),
            longDateFormat: {
                LT: 'HH:mm',
                LTS: 'LT:ss',
                L: 'YYYY-MM-DD',
                LL: 'D[-an de] MMMM, YYYY',
                LLL: 'D[-an de] MMMM, YYYY LT',
                LLLL: 'dddd, [la] D[-an de] MMMM, YYYY LT'
            },
            meridiemParse: /[ap]\.t\.m/i,
            isPM: function (input) {
                return input.charAt(0).toLowerCase() === 'p';
            },
            meridiem: function (hours, minutes, isLower) {
                if (hours > 11) {
                    return isLower ? 'p.t.m.' : 'P.T.M.';
                } else {
                    return isLower ? 'a.t.m.' : 'A.T.M.';
                }
            },
            calendar: {
                sameDay: '[Hodia?? je] LT',
                nextDay: '[Morga?? je] LT',
                nextWeek: 'dddd [je] LT',
                lastDay: '[Hiera?? je] LT',
                lastWeek: '[pasinta] dddd [je] LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: 'je %s',
                past: 'anta?? %s',
                s: 'sekundoj',
                m: 'minuto',
                mm: '%d minutoj',
                h: 'horo',
                hh: '%d horoj',
                d: 'tago', //ne 'diurno', ??ar estas uzita por proksimumo
                dd: '%d tagoj',
                M: 'monato',
                MM: '%d monatoj',
                y: 'jaro',
                yy: '%d jaroj'
            },
            ordinalParse: /\d{1,2}a/,
            ordinal: '%da',
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 7  // The week that contains Jan 1st is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : spanish (es)
// author : Julio Napur?? : https://github.com/julionc

    (function (factory) {
        factory(moment);
    }(function (moment) {
        var monthsShortDot = 'ene._feb._mar._abr._may._jun._jul._ago._sep._oct._nov._dic.'.split('_'),
                monthsShort = 'ene_feb_mar_abr_may_jun_jul_ago_sep_oct_nov_dic'.split('_');

        return moment.defineLocale('es', {
            months: 'enero_febrero_marzo_abril_mayo_junio_julio_agosto_septiembre_octubre_noviembre_diciembre'.split('_'),
            monthsShort: function (m, format) {
                if (/-MMM-/.test(format)) {
                    return monthsShort[m.month()];
                } else {
                    return monthsShortDot[m.month()];
                }
            },
            weekdays: 'domingo_lunes_martes_mi??rcoles_jueves_viernes_s??bado'.split('_'),
            weekdaysShort: 'dom._lun._mar._mi??._jue._vie._s??b.'.split('_'),
            weekdaysMin: 'Do_Lu_Ma_Mi_Ju_Vi_S??'.split('_'),
            longDateFormat: {
                LT: 'H:mm',
                LTS: 'LT:ss',
                L: 'DD/MM/YYYY',
                LL: 'D [de] MMMM [de] YYYY',
                LLL: 'D [de] MMMM [de] YYYY LT',
                LLLL: 'dddd, D [de] MMMM [de] YYYY LT'
            },
            calendar: {
                sameDay: function () {
                    return '[hoy a la' + ((this.hours() !== 1) ? 's' : '') + '] LT';
                },
                nextDay: function () {
                    return '[ma??ana a la' + ((this.hours() !== 1) ? 's' : '') + '] LT';
                },
                nextWeek: function () {
                    return 'dddd [a la' + ((this.hours() !== 1) ? 's' : '') + '] LT';
                },
                lastDay: function () {
                    return '[ayer a la' + ((this.hours() !== 1) ? 's' : '') + '] LT';
                },
                lastWeek: function () {
                    return '[el] dddd [pasado a la' + ((this.hours() !== 1) ? 's' : '') + '] LT';
                },
                sameElse: 'L'
            },
            relativeTime: {
                future: 'en %s',
                past: 'hace %s',
                s: 'unos segundos',
                m: 'un minuto',
                mm: '%d minutos',
                h: 'una hora',
                hh: '%d horas',
                d: 'un d??a',
                dd: '%d d??as',
                M: 'un mes',
                MM: '%d meses',
                y: 'un a??o',
                yy: '%d a??os'
            },
            ordinalParse: /\d{1,2}??/,
            ordinal: '%d??',
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 4  // The week that contains Jan 4th is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : estonian (et)
// author : Henry Kehlmann : https://github.com/madhenry
// improvements : Illimar Tambek : https://github.com/ragulka

    (function (factory) {
        factory(moment);
    }(function (moment) {
        function processRelativeTime(number, withoutSuffix, key, isFuture) {
            var format = {
                's': ['m??ne sekundi', 'm??ni sekund', 'paar sekundit'],
                'm': ['??he minuti', '??ks minut'],
                'mm': [number + ' minuti', number + ' minutit'],
                'h': ['??he tunni', 'tund aega', '??ks tund'],
                'hh': [number + ' tunni', number + ' tundi'],
                'd': ['??he p??eva', '??ks p??ev'],
                'M': ['kuu aja', 'kuu aega', '??ks kuu'],
                'MM': [number + ' kuu', number + ' kuud'],
                'y': ['??he aasta', 'aasta', '??ks aasta'],
                'yy': [number + ' aasta', number + ' aastat']
            };
            if (withoutSuffix) {
                return format[key][2] ? format[key][2] : format[key][1];
            }
            return isFuture ? format[key][0] : format[key][1];
        }

        return moment.defineLocale('et', {
            months: 'jaanuar_veebruar_m??rts_aprill_mai_juuni_juuli_august_september_oktoober_november_detsember'.split('_'),
            monthsShort: 'jaan_veebr_m??rts_apr_mai_juuni_juuli_aug_sept_okt_nov_dets'.split('_'),
            weekdays: 'p??hap??ev_esmasp??ev_teisip??ev_kolmap??ev_neljap??ev_reede_laup??ev'.split('_'),
            weekdaysShort: 'P_E_T_K_N_R_L'.split('_'),
            weekdaysMin: 'P_E_T_K_N_R_L'.split('_'),
            longDateFormat: {
                LT: 'H:mm',
                LTS: 'LT:ss',
                L: 'DD.MM.YYYY',
                LL: 'D. MMMM YYYY',
                LLL: 'D. MMMM YYYY LT',
                LLLL: 'dddd, D. MMMM YYYY LT'
            },
            calendar: {
                sameDay: '[T??na,] LT',
                nextDay: '[Homme,] LT',
                nextWeek: '[J??rgmine] dddd LT',
                lastDay: '[Eile,] LT',
                lastWeek: '[Eelmine] dddd LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: '%s p??rast',
                past: '%s tagasi',
                s: processRelativeTime,
                m: processRelativeTime,
                mm: processRelativeTime,
                h: processRelativeTime,
                hh: processRelativeTime,
                d: processRelativeTime,
                dd: '%d p??eva',
                M: processRelativeTime,
                MM: processRelativeTime,
                y: processRelativeTime,
                yy: processRelativeTime
            },
            ordinalParse: /\d{1,2}\./,
            ordinal: '%d.',
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 4  // The week that contains Jan 4th is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : euskara (eu)
// author : Eneko Illarramendi : https://github.com/eillarra

    (function (factory) {
        factory(moment);
    }(function (moment) {
        return moment.defineLocale('eu', {
            months: 'urtarrila_otsaila_martxoa_apirila_maiatza_ekaina_uztaila_abuztua_iraila_urria_azaroa_abendua'.split('_'),
            monthsShort: 'urt._ots._mar._api._mai._eka._uzt._abu._ira._urr._aza._abe.'.split('_'),
            weekdays: 'igandea_astelehena_asteartea_asteazkena_osteguna_ostirala_larunbata'.split('_'),
            weekdaysShort: 'ig._al._ar._az._og._ol._lr.'.split('_'),
            weekdaysMin: 'ig_al_ar_az_og_ol_lr'.split('_'),
            longDateFormat: {
                LT: 'HH:mm',
                LTS: 'LT:ss',
                L: 'YYYY-MM-DD',
                LL: 'YYYY[ko] MMMM[ren] D[a]',
                LLL: 'YYYY[ko] MMMM[ren] D[a] LT',
                LLLL: 'dddd, YYYY[ko] MMMM[ren] D[a] LT',
                l: 'YYYY-M-D',
                ll: 'YYYY[ko] MMM D[a]',
                lll: 'YYYY[ko] MMM D[a] LT',
                llll: 'ddd, YYYY[ko] MMM D[a] LT'
            },
            calendar: {
                sameDay: '[gaur] LT[etan]',
                nextDay: '[bihar] LT[etan]',
                nextWeek: 'dddd LT[etan]',
                lastDay: '[atzo] LT[etan]',
                lastWeek: '[aurreko] dddd LT[etan]',
                sameElse: 'L'
            },
            relativeTime: {
                future: '%s barru',
                past: 'duela %s',
                s: 'segundo batzuk',
                m: 'minutu bat',
                mm: '%d minutu',
                h: 'ordu bat',
                hh: '%d ordu',
                d: 'egun bat',
                dd: '%d egun',
                M: 'hilabete bat',
                MM: '%d hilabete',
                y: 'urte bat',
                yy: '%d urte'
            },
            ordinalParse: /\d{1,2}\./,
            ordinal: '%d.',
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 7  // The week that contains Jan 1st is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : Persian (fa)
// author : Ebrahim Byagowi : https://github.com/ebraminio

    (function (factory) {
        factory(moment);
    }(function (moment) {
        var symbolMap = {
            '1': '??',
            '2': '??',
            '3': '??',
            '4': '??',
            '5': '??',
            '6': '??',
            '7': '??',
            '8': '??',
            '9': '??',
            '0': '??'
        }, numberMap = {
            '??': '1',
            '??': '2',
            '??': '3',
            '??': '4',
            '??': '5',
            '??': '6',
            '??': '7',
            '??': '8',
            '??': '9',
            '??': '0'
        };

        return moment.defineLocale('fa', {
            months: '????????????_??????????_????????_??????????_????_????????_??????????_??????_??????????????_??????????_????????????_????????????'.split('_'),
            monthsShort: '????????????_??????????_????????_??????????_????_????????_??????????_??????_??????????????_??????????_????????????_????????????'.split('_'),
            weekdays: '????\u200c????????_????????????_????\u200c????????_????????????????_??????\u200c????????_????????_????????'.split('_'),
            weekdaysShort: '????\u200c????????_????????????_????\u200c????????_????????????????_??????\u200c????????_????????_????????'.split('_'),
            weekdaysMin: '??_??_??_??_??_??_??'.split('_'),
            longDateFormat: {
                LT: 'HH:mm',
                LTS: 'LT:ss',
                L: 'DD/MM/YYYY',
                LL: 'D MMMM YYYY',
                LLL: 'D MMMM YYYY LT',
                LLLL: 'dddd, D MMMM YYYY LT'
            },
            meridiemParse: /?????? ???? ??????|?????? ???? ??????/,
            isPM: function (input) {
                return /?????? ???? ??????/.test(input);
            },
            meridiem: function (hour, minute, isLower) {
                if (hour < 12) {
                    return '?????? ???? ??????';
                } else {
                    return '?????? ???? ??????';
                }
            },
            calendar: {
                sameDay: '[?????????? ????????] LT',
                nextDay: '[???????? ????????] LT',
                nextWeek: 'dddd [????????] LT',
                lastDay: '[?????????? ????????] LT',
                lastWeek: 'dddd [??????] [????????] LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: '???? %s',
                past: '%s ??????',
                s: '?????????? ??????????',
                m: '???? ??????????',
                mm: '%d ??????????',
                h: '???? ????????',
                hh: '%d ????????',
                d: '???? ??????',
                dd: '%d ??????',
                M: '???? ??????',
                MM: '%d ??????',
                y: '???? ??????',
                yy: '%d ??????'
            },
            preparse: function (string) {
                return string.replace(/[??-??]/g, function (match) {
                    return numberMap[match];
                }).replace(/??/g, ',');
            },
            postformat: function (string) {
                return string.replace(/\d/g, function (match) {
                    return symbolMap[match];
                }).replace(/,/g, '??');
            },
            ordinalParse: /\d{1,2}??/,
            ordinal: '%d??',
            week: {
                dow: 6, // Saturday is the first day of the week.
                doy: 12 // The week that contains Jan 1st is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : finnish (fi)
// author : Tarmo Aidantausta : https://github.com/bleadof

    (function (factory) {
        factory(moment);
    }(function (moment) {
        var numbersPast = 'nolla yksi kaksi kolme nelj?? viisi kuusi seitsem??n kahdeksan yhdeks??n'.split(' '),
                numbersFuture = [
                    'nolla', 'yhden', 'kahden', 'kolmen', 'nelj??n', 'viiden', 'kuuden',
                    numbersPast[7], numbersPast[8], numbersPast[9]
                ];

        function translate(number, withoutSuffix, key, isFuture) {
            var result = '';
            switch (key) {
                case 's':
                    return isFuture ? 'muutaman sekunnin' : 'muutama sekunti';
                case 'm':
                    return isFuture ? 'minuutin' : 'minuutti';
                case 'mm':
                    result = isFuture ? 'minuutin' : 'minuuttia';
                    break;
                case 'h':
                    return isFuture ? 'tunnin' : 'tunti';
                case 'hh':
                    result = isFuture ? 'tunnin' : 'tuntia';
                    break;
                case 'd':
                    return isFuture ? 'p??iv??n' : 'p??iv??';
                case 'dd':
                    result = isFuture ? 'p??iv??n' : 'p??iv????';
                    break;
                case 'M':
                    return isFuture ? 'kuukauden' : 'kuukausi';
                case 'MM':
                    result = isFuture ? 'kuukauden' : 'kuukautta';
                    break;
                case 'y':
                    return isFuture ? 'vuoden' : 'vuosi';
                case 'yy':
                    result = isFuture ? 'vuoden' : 'vuotta';
                    break;
            }
            result = verbalNumber(number, isFuture) + ' ' + result;
            return result;
        }

        function verbalNumber(number, isFuture) {
            return number < 10 ? (isFuture ? numbersFuture[number] : numbersPast[number]) : number;
        }

        return moment.defineLocale('fi', {
            months: 'tammikuu_helmikuu_maaliskuu_huhtikuu_toukokuu_kes??kuu_hein??kuu_elokuu_syyskuu_lokakuu_marraskuu_joulukuu'.split('_'),
            monthsShort: 'tammi_helmi_maalis_huhti_touko_kes??_hein??_elo_syys_loka_marras_joulu'.split('_'),
            weekdays: 'sunnuntai_maanantai_tiistai_keskiviikko_torstai_perjantai_lauantai'.split('_'),
            weekdaysShort: 'su_ma_ti_ke_to_pe_la'.split('_'),
            weekdaysMin: 'su_ma_ti_ke_to_pe_la'.split('_'),
            longDateFormat: {
                LT: 'HH.mm',
                LTS: 'HH.mm.ss',
                L: 'DD.MM.YYYY',
                LL: 'Do MMMM[ta] YYYY',
                LLL: 'Do MMMM[ta] YYYY, [klo] LT',
                LLLL: 'dddd, Do MMMM[ta] YYYY, [klo] LT',
                l: 'D.M.YYYY',
                ll: 'Do MMM YYYY',
                lll: 'Do MMM YYYY, [klo] LT',
                llll: 'ddd, Do MMM YYYY, [klo] LT'
            },
            calendar: {
                sameDay: '[t??n????n] [klo] LT',
                nextDay: '[huomenna] [klo] LT',
                nextWeek: 'dddd [klo] LT',
                lastDay: '[eilen] [klo] LT',
                lastWeek: '[viime] dddd[na] [klo] LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: '%s p????st??',
                past: '%s sitten',
                s: translate,
                m: translate,
                mm: translate,
                h: translate,
                hh: translate,
                d: translate,
                dd: translate,
                M: translate,
                MM: translate,
                y: translate,
                yy: translate
            },
            ordinalParse: /\d{1,2}\./,
            ordinal: '%d.',
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 4  // The week that contains Jan 4th is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : faroese (fo)
// author : Ragnar Johannesen : https://github.com/ragnar123

    (function (factory) {
        factory(moment);
    }(function (moment) {
        return moment.defineLocale('fo', {
            months: 'januar_februar_mars_apr??l_mai_juni_juli_august_september_oktober_november_desember'.split('_'),
            monthsShort: 'jan_feb_mar_apr_mai_jun_jul_aug_sep_okt_nov_des'.split('_'),
            weekdays: 'sunnudagur_m??nadagur_t??sdagur_mikudagur_h??sdagur_fr??ggjadagur_leygardagur'.split('_'),
            weekdaysShort: 'sun_m??n_t??s_mik_h??s_fr??_ley'.split('_'),
            weekdaysMin: 'su_m??_t??_mi_h??_fr_le'.split('_'),
            longDateFormat: {
                LT: 'HH:mm',
                LTS: 'LT:ss',
                L: 'DD/MM/YYYY',
                LL: 'D MMMM YYYY',
                LLL: 'D MMMM YYYY LT',
                LLLL: 'dddd D. MMMM, YYYY LT'
            },
            calendar: {
                sameDay: '[?? dag kl.] LT',
                nextDay: '[?? morgin kl.] LT',
                nextWeek: 'dddd [kl.] LT',
                lastDay: '[?? gj??r kl.] LT',
                lastWeek: '[s????stu] dddd [kl] LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: 'um %s',
                past: '%s s????ani',
                s: 'f?? sekund',
                m: 'ein minutt',
                mm: '%d minuttir',
                h: 'ein t??mi',
                hh: '%d t??mar',
                d: 'ein dagur',
                dd: '%d dagar',
                M: 'ein m??na??i',
                MM: '%d m??na??ir',
                y: 'eitt ??r',
                yy: '%d ??r'
            },
            ordinalParse: /\d{1,2}\./,
            ordinal: '%d.',
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 4  // The week that contains Jan 4th is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : canadian french (fr-ca)
// author : Jonathan Abourbih : https://github.com/jonbca

    (function (factory) {
        factory(moment);
    }(function (moment) {
        return moment.defineLocale('fr-ca', {
            months: 'janvier_f??vrier_mars_avril_mai_juin_juillet_ao??t_septembre_octobre_novembre_d??cembre'.split('_'),
            monthsShort: 'janv._f??vr._mars_avr._mai_juin_juil._ao??t_sept._oct._nov._d??c.'.split('_'),
            weekdays: 'dimanche_lundi_mardi_mercredi_jeudi_vendredi_samedi'.split('_'),
            weekdaysShort: 'dim._lun._mar._mer._jeu._ven._sam.'.split('_'),
            weekdaysMin: 'Di_Lu_Ma_Me_Je_Ve_Sa'.split('_'),
            longDateFormat: {
                LT: 'HH:mm',
                LTS: 'LT:ss',
                L: 'YYYY-MM-DD',
                LL: 'D MMMM YYYY',
                LLL: 'D MMMM YYYY LT',
                LLLL: 'dddd D MMMM YYYY LT'
            },
            calendar: {
                sameDay: '[Aujourd\'hui ??] LT',
                nextDay: '[Demain ??] LT',
                nextWeek: 'dddd [??] LT',
                lastDay: '[Hier ??] LT',
                lastWeek: 'dddd [dernier ??] LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: 'dans %s',
                past: 'il y a %s',
                s: 'quelques secondes',
                m: 'une minute',
                mm: '%d minutes',
                h: 'une heure',
                hh: '%d heures',
                d: 'un jour',
                dd: '%d jours',
                M: 'un mois',
                MM: '%d mois',
                y: 'un an',
                yy: '%d ans'
            },
            ordinalParse: /\d{1,2}(er|)/,
            ordinal: function (number) {
                return number + (number === 1 ? 'er' : '');
            }
        });
    }));
// moment.js locale configuration
// locale : french (fr)
// author : John Fischer : https://github.com/jfroffice

    (function (factory) {
        factory(moment);
    }(function (moment) {
        return moment.defineLocale('fr', {
            months: 'janvier_f??vrier_mars_avril_mai_juin_juillet_ao??t_septembre_octobre_novembre_d??cembre'.split('_'),
            monthsShort: 'janv._f??vr._mars_avr._mai_juin_juil._ao??t_sept._oct._nov._d??c.'.split('_'),
            weekdays: 'dimanche_lundi_mardi_mercredi_jeudi_vendredi_samedi'.split('_'),
            weekdaysShort: 'dim._lun._mar._mer._jeu._ven._sam.'.split('_'),
            weekdaysMin: 'Di_Lu_Ma_Me_Je_Ve_Sa'.split('_'),
            longDateFormat: {
                LT: 'HH:mm',
                LTS: 'LT:ss',
                L: 'DD/MM/YYYY',
                LL: 'D MMMM YYYY',
                LLL: 'D MMMM YYYY LT',
                LLLL: 'dddd D MMMM YYYY LT'
            },
            calendar: {
                sameDay: '[Aujourd\'hui ??] LT',
                nextDay: '[Demain ??] LT',
                nextWeek: 'dddd [??] LT',
                lastDay: '[Hier ??] LT',
                lastWeek: 'dddd [dernier ??] LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: 'dans %s',
                past: 'il y a %s',
                s: 'quelques secondes',
                m: 'une minute',
                mm: '%d minutes',
                h: 'une heure',
                hh: '%d heures',
                d: 'un jour',
                dd: '%d jours',
                M: 'un mois',
                MM: '%d mois',
                y: 'un an',
                yy: '%d ans'
            },
            ordinalParse: /\d{1,2}(er|)/,
            ordinal: function (number) {
                return number + (number === 1 ? 'er' : '');
            },
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 4  // The week that contains Jan 4th is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : frisian (fy)
// author : Robin van der Vliet : https://github.com/robin0van0der0v

    (function (factory) {
        factory(moment);
    }(function (moment) {
        var monthsShortWithDots = 'jan._feb._mrt._apr._mai_jun._jul._aug._sep._okt._nov._des.'.split('_'),
                monthsShortWithoutDots = 'jan_feb_mrt_apr_mai_jun_jul_aug_sep_okt_nov_des'.split('_');

        return moment.defineLocale('fy', {
            months: 'jannewaris_febrewaris_maart_april_maaie_juny_july_augustus_septimber_oktober_novimber_desimber'.split('_'),
            monthsShort: function (m, format) {
                if (/-MMM-/.test(format)) {
                    return monthsShortWithoutDots[m.month()];
                } else {
                    return monthsShortWithDots[m.month()];
                }
            },
            weekdays: 'snein_moandei_tiisdei_woansdei_tongersdei_freed_sneon'.split('_'),
            weekdaysShort: 'si._mo._ti._wo._to._fr._so.'.split('_'),
            weekdaysMin: 'Si_Mo_Ti_Wo_To_Fr_So'.split('_'),
            longDateFormat: {
                LT: 'HH:mm',
                LTS: 'LT:ss',
                L: 'DD-MM-YYYY',
                LL: 'D MMMM YYYY',
                LLL: 'D MMMM YYYY LT',
                LLLL: 'dddd D MMMM YYYY LT'
            },
            calendar: {
                sameDay: '[hjoed om] LT',
                nextDay: '[moarn om] LT',
                nextWeek: 'dddd [om] LT',
                lastDay: '[juster om] LT',
                lastWeek: '[??fr??ne] dddd [om] LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: 'oer %s',
                past: '%s lyn',
                s: 'in pear sekonden',
                m: 'ien min??t',
                mm: '%d minuten',
                h: 'ien oere',
                hh: '%d oeren',
                d: 'ien dei',
                dd: '%d dagen',
                M: 'ien moanne',
                MM: '%d moannen',
                y: 'ien jier',
                yy: '%d jierren'
            },
            ordinalParse: /\d{1,2}(ste|de)/,
            ordinal: function (number) {
                return number + ((number === 1 || number === 8 || number >= 20) ? 'ste' : 'de');
            },
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 4  // The week that contains Jan 4th is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : galician (gl)
// author : Juan G. Hurtado : https://github.com/juanghurtado

    (function (factory) {
        factory(moment);
    }(function (moment) {
        return moment.defineLocale('gl', {
            months: 'Xaneiro_Febreiro_Marzo_Abril_Maio_Xu??o_Xullo_Agosto_Setembro_Outubro_Novembro_Decembro'.split('_'),
            monthsShort: 'Xan._Feb._Mar._Abr._Mai._Xu??._Xul._Ago._Set._Out._Nov._Dec.'.split('_'),
            weekdays: 'Domingo_Luns_Martes_M??rcores_Xoves_Venres_S??bado'.split('_'),
            weekdaysShort: 'Dom._Lun._Mar._M??r._Xov._Ven._S??b.'.split('_'),
            weekdaysMin: 'Do_Lu_Ma_M??_Xo_Ve_S??'.split('_'),
            longDateFormat: {
                LT: 'H:mm',
                LTS: 'LT:ss',
                L: 'DD/MM/YYYY',
                LL: 'D MMMM YYYY',
                LLL: 'D MMMM YYYY LT',
                LLLL: 'dddd D MMMM YYYY LT'
            },
            calendar: {
                sameDay: function () {
                    return '[hoxe ' + ((this.hours() !== 1) ? '??s' : '??') + '] LT';
                },
                nextDay: function () {
                    return '[ma???? ' + ((this.hours() !== 1) ? '??s' : '??') + '] LT';
                },
                nextWeek: function () {
                    return 'dddd [' + ((this.hours() !== 1) ? '??s' : 'a') + '] LT';
                },
                lastDay: function () {
                    return '[onte ' + ((this.hours() !== 1) ? '??' : 'a') + '] LT';
                },
                lastWeek: function () {
                    return '[o] dddd [pasado ' + ((this.hours() !== 1) ? '??s' : 'a') + '] LT';
                },
                sameElse: 'L'
            },
            relativeTime: {
                future: function (str) {
                    if (str === 'uns segundos') {
                        return 'nuns segundos';
                    }
                    return 'en ' + str;
                },
                past: 'hai %s',
                s: 'uns segundos',
                m: 'un minuto',
                mm: '%d minutos',
                h: 'unha hora',
                hh: '%d horas',
                d: 'un d??a',
                dd: '%d d??as',
                M: 'un mes',
                MM: '%d meses',
                y: 'un ano',
                yy: '%d anos'
            },
            ordinalParse: /\d{1,2}??/,
            ordinal: '%d??',
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 7  // The week that contains Jan 1st is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : Hebrew (he)
// author : Tomer Cohen : https://github.com/tomer
// author : Moshe Simantov : https://github.com/DevelopmentIL
// author : Tal Ater : https://github.com/TalAter

    (function (factory) {
        factory(moment);
    }(function (moment) {
        return moment.defineLocale('he', {
            months: '??????????_????????????_??????_??????????_??????_????????_????????_????????????_????????????_??????????????_????????????_??????????'.split('_'),
            monthsShort: '????????_????????_??????_????????_??????_????????_????????_????????_????????_????????_????????_????????'.split('_'),
            weekdays: '??????????_??????_??????????_??????????_??????????_????????_??????'.split('_'),
            weekdaysShort: '????_????_????_????_????_????_????'.split('_'),
            weekdaysMin: '??_??_??_??_??_??_??'.split('_'),
            longDateFormat: {
                LT: 'HH:mm',
                LTS: 'LT:ss',
                L: 'DD/MM/YYYY',
                LL: 'D [??]MMMM YYYY',
                LLL: 'D [??]MMMM YYYY LT',
                LLLL: 'dddd, D [??]MMMM YYYY LT',
                l: 'D/M/YYYY',
                ll: 'D MMM YYYY',
                lll: 'D MMM YYYY LT',
                llll: 'ddd, D MMM YYYY LT'
            },
            calendar: {
                sameDay: '[???????? ????]LT',
                nextDay: '[?????? ????]LT',
                nextWeek: 'dddd [????????] LT',
                lastDay: '[?????????? ????]LT',
                lastWeek: '[????????] dddd [???????????? ????????] LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: '???????? %s',
                past: '???????? %s',
                s: '???????? ??????????',
                m: '??????',
                mm: '%d ????????',
                h: '??????',
                hh: function (number) {
                    if (number === 2) {
                        return '????????????';
                    }
                    return number + ' ????????';
                },
                d: '??????',
                dd: function (number) {
                    if (number === 2) {
                        return '????????????';
                    }
                    return number + ' ????????';
                },
                M: '????????',
                MM: function (number) {
                    if (number === 2) {
                        return '??????????????';
                    }
                    return number + ' ????????????';
                },
                y: '??????',
                yy: function (number) {
                    if (number === 2) {
                        return '????????????';
                    } else if (number % 10 === 0 && number !== 10) {
                        return number + ' ??????';
                    }
                    return number + ' ????????';
                }
            }
        });
    }));
// moment.js locale configuration
// locale : hindi (hi)
// author : Mayank Singhal : https://github.com/mayanksinghal

    (function (factory) {
        factory(moment);
    }(function (moment) {
        var symbolMap = {
            '1': '???',
            '2': '???',
            '3': '???',
            '4': '???',
            '5': '???',
            '6': '???',
            '7': '???',
            '8': '???',
            '9': '???',
            '0': '???'
        },
                numberMap = {
                    '???': '1',
                    '???': '2',
                    '???': '3',
                    '???': '4',
                    '???': '5',
                    '???': '6',
                    '???': '7',
                    '???': '8',
                    '???': '9',
                    '???': '0'
                };

        return moment.defineLocale('hi', {
            months: '???????????????_??????????????????_???????????????_??????????????????_??????_?????????_???????????????_???????????????_?????????????????????_?????????????????????_??????????????????_?????????????????????'.split('_'),
            monthsShort: '??????._?????????._???????????????_???????????????._??????_?????????_?????????._??????._?????????._???????????????._??????._?????????.'.split('_'),
            weekdays: '??????????????????_??????????????????_?????????????????????_??????????????????_?????????????????????_????????????????????????_??????????????????'.split('_'),
            weekdaysShort: '?????????_?????????_????????????_?????????_????????????_???????????????_?????????'.split('_'),
            weekdaysMin: '???_??????_??????_??????_??????_??????_???'.split('_'),
            longDateFormat: {
                LT: 'A h:mm ?????????',
                LTS: 'A h:mm:ss ?????????',
                L: 'DD/MM/YYYY',
                LL: 'D MMMM YYYY',
                LLL: 'D MMMM YYYY, LT',
                LLLL: 'dddd, D MMMM YYYY, LT'
            },
            calendar: {
                sameDay: '[??????] LT',
                nextDay: '[??????] LT',
                nextWeek: 'dddd, LT',
                lastDay: '[??????] LT',
                lastWeek: '[???????????????] dddd, LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: '%s ?????????',
                past: '%s ????????????',
                s: '????????? ?????? ????????????',
                m: '?????? ????????????',
                mm: '%d ????????????',
                h: '?????? ????????????',
                hh: '%d ????????????',
                d: '?????? ?????????',
                dd: '%d ?????????',
                M: '?????? ???????????????',
                MM: '%d ???????????????',
                y: '?????? ????????????',
                yy: '%d ????????????'
            },
            preparse: function (string) {
                return string.replace(/[??????????????????????????????]/g, function (match) {
                    return numberMap[match];
                });
            },
            postformat: function (string) {
                return string.replace(/\d/g, function (match) {
                    return symbolMap[match];
                });
            },
            // Hindi notation for meridiems are quite fuzzy in practice. While there exists
            // a rigid notion of a 'Pahar' it is not used as rigidly in modern Hindi.
            meridiemParse: /?????????|????????????|???????????????|?????????/,
            meridiemHour: function (hour, meridiem) {
                if (hour === 12) {
                    hour = 0;
                }
                if (meridiem === '?????????') {
                    return hour < 4 ? hour : hour + 12;
                } else if (meridiem === '????????????') {
                    return hour;
                } else if (meridiem === '???????????????') {
                    return hour >= 10 ? hour : hour + 12;
                } else if (meridiem === '?????????') {
                    return hour + 12;
                }
            },
            meridiem: function (hour, minute, isLower) {
                if (hour < 4) {
                    return '?????????';
                } else if (hour < 10) {
                    return '????????????';
                } else if (hour < 17) {
                    return '???????????????';
                } else if (hour < 20) {
                    return '?????????';
                } else {
                    return '?????????';
                }
            },
            week: {
                dow: 0, // Sunday is the first day of the week.
                doy: 6  // The week that contains Jan 1st is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : hrvatski (hr)
// author : Bojan Markovi?? : https://github.com/bmarkovic

// based on (sl) translation by Robert Sedov??ek

    (function (factory) {
        factory(moment);
    }(function (moment) {
        function translate(number, withoutSuffix, key) {
            var result = number + ' ';
            switch (key) {
                case 'm':
                    return withoutSuffix ? 'jedna minuta' : 'jedne minute';
                case 'mm':
                    if (number === 1) {
                        result += 'minuta';
                    } else if (number === 2 || number === 3 || number === 4) {
                        result += 'minute';
                    } else {
                        result += 'minuta';
                    }
                    return result;
                case 'h':
                    return withoutSuffix ? 'jedan sat' : 'jednog sata';
                case 'hh':
                    if (number === 1) {
                        result += 'sat';
                    } else if (number === 2 || number === 3 || number === 4) {
                        result += 'sata';
                    } else {
                        result += 'sati';
                    }
                    return result;
                case 'dd':
                    if (number === 1) {
                        result += 'dan';
                    } else {
                        result += 'dana';
                    }
                    return result;
                case 'MM':
                    if (number === 1) {
                        result += 'mjesec';
                    } else if (number === 2 || number === 3 || number === 4) {
                        result += 'mjeseca';
                    } else {
                        result += 'mjeseci';
                    }
                    return result;
                case 'yy':
                    if (number === 1) {
                        result += 'godina';
                    } else if (number === 2 || number === 3 || number === 4) {
                        result += 'godine';
                    } else {
                        result += 'godina';
                    }
                    return result;
            }
        }

        return moment.defineLocale('hr', {
            months: 'sje??anj_velja??a_o??ujak_travanj_svibanj_lipanj_srpanj_kolovoz_rujan_listopad_studenisinac'.split('_'),
            monthsShort: 'sje._vel._o??u._tra._svi._lip._srp._kol._ruj._lis._stu..'.split('_'),
            weekdays: 'nedjelja_ponedjeljak_utorak_srijeda_??etvrtak_petak_subota'.split('_'),
            weekdaysShort: 'ned._pon._uto._sri._??et._pet._sub.'.split('_'),
            weekdaysMin: 'ne_po_ut_sr_??e_pe_su'.split('_'),
            longDateFormat: {
                LT: 'H:mm',
                LTS: 'LT:ss',
                L: 'DD. MM. YYYY',
                LL: 'D. MMMM YYYY',
                LLL: 'D. MMMM YYYY LT',
                LLLL: 'dddd, D. MMMM YYYY LT'
            },
            calendar: {
                sameDay: '[danas u] LT',
                nextDay: '[sutra u] LT',

                nextWeek: function () {
                    switch (this.day()) {
                        case 0:
                            return '[u] [nedjelju] [u] LT';
                        case 3:
                            return '[u] [srijedu] [u] LT';
                        case 6:
                            return '[u] [subotu] [u] LT';
                        case 1:
                        case 2:
                        case 4:
                        case 5:
                            return '[u] dddd [u] LT';
                    }
                },
                lastDay: '[ju??er u] LT',
                lastWeek: function () {
                    switch (this.day()) {
                        case 0:
                        case 3:
                            return '[pro??lu] dddd [u] LT';
                        case 6:
                            return '[pro??le] [subote] [u] LT';
                        case 1:
                        case 2:
                        case 4:
                        case 5:
                            return '[pro??li] dddd [u] LT';
                    }
                },
                sameElse: 'L'
            },
            relativeTime: {
                future: 'za %s',
                past: 'prije %s',
                s: 'par sekundi',
                m: translate,
                mm: translate,
                h: translate,
                hh: translate,
                d: 'dan',
                dd: translate,
                M: 'mjesec',
                MM: translate,
                y: 'godinu',
                yy: translate
            },
            ordinalParse: /\d{1,2}\./,
            ordinal: '%d.',
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 7  // The week that contains Jan 1st is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : hungarian (hu)
// author : Adam Brunner : https://github.com/adambrunner

    (function (factory) {
        factory(moment);
    }(function (moment) {
        var weekEndings = 'vas??rnap h??tf??n kedden szerd??n cs??t??rt??k??n p??nteken szombaton'.split(' ');

        function translate(number, withoutSuffix, key, isFuture) {
            var num = number,
                    suffix;

            switch (key) {
                case 's':
                    return (isFuture || withoutSuffix) ? 'n??h??ny m??sodperc' : 'n??h??ny m??sodperce';
                case 'm':
                    return 'egy' + (isFuture || withoutSuffix ? ' perc' : ' perce');
                case 'mm':
                    return num + (isFuture || withoutSuffix ? ' perc' : ' perce');
                case 'h':
                    return 'egy' + (isFuture || withoutSuffix ? ' ??ra' : ' ??r??ja');
                case 'hh':
                    return num + (isFuture || withoutSuffix ? ' ??ra' : ' ??r??ja');
                case 'd':
                    return 'egy' + (isFuture || withoutSuffix ? ' nap' : ' napja');
                case 'dd':
                    return num + (isFuture || withoutSuffix ? ' nap' : ' napja');
                case 'M':
                    return 'egy' + (isFuture || withoutSuffix ? ' h??nap' : ' h??napja');
                case 'MM':
                    return num + (isFuture || withoutSuffix ? ' h??nap' : ' h??napja');
                case 'y':
                    return 'egy' + (isFuture || withoutSuffix ? ' ??v' : ' ??ve');
                case 'yy':
                    return num + (isFuture || withoutSuffix ? ' ??v' : ' ??ve');
            }

            return '';
        }

        function week(isFuture) {
            return (isFuture ? '' : '[m??lt] ') + '[' + weekEndings[this.day()] + '] LT[-kor]';
        }

        return moment.defineLocale('hu', {
            months: 'janu??r_febru??r_m??rcius_??prilis_m??jus_j??nius_j??lius_augusztus_szeptember_okt??ber_november_december'.split('_'),
            monthsShort: 'jan_feb_m??rc_??pr_m??j_j??n_j??l_aug_szept_okt_nov_dec'.split('_'),
            weekdays: 'vas??rnap_h??tf??_kedd_szerda_cs??t??rt??k_p??ntek_szombat'.split('_'),
            weekdaysShort: 'vas_h??t_kedd_sze_cs??t_p??n_szo'.split('_'),
            weekdaysMin: 'v_h_k_sze_cs_p_szo'.split('_'),
            longDateFormat: {
                LT: 'H:mm',
                LTS: 'LT:ss',
                L: 'YYYY.MM.DD.',
                LL: 'YYYY. MMMM D.',
                LLL: 'YYYY. MMMM D., LT',
                LLLL: 'YYYY. MMMM D., dddd LT'
            },
            meridiemParse: /de|du/i,
            isPM: function (input) {
                return input.charAt(1).toLowerCase() === 'u';
            },
            meridiem: function (hours, minutes, isLower) {
                if (hours < 12) {
                    return isLower === true ? 'de' : 'DE';
                } else {
                    return isLower === true ? 'du' : 'DU';
                }
            },
            calendar: {
                sameDay: '[ma] LT[-kor]',
                nextDay: '[holnap] LT[-kor]',
                nextWeek: function () {
                    return week.call(this, true);
                },
                lastDay: '[tegnap] LT[-kor]',
                lastWeek: function () {
                    return week.call(this, false);
                },
                sameElse: 'L'
            },
            relativeTime: {
                future: '%s m??lva',
                past: '%s',
                s: translate,
                m: translate,
                mm: translate,
                h: translate,
                hh: translate,
                d: translate,
                dd: translate,
                M: translate,
                MM: translate,
                y: translate,
                yy: translate
            },
            ordinalParse: /\d{1,2}\./,
            ordinal: '%d.',
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 7  // The week that contains Jan 1st is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : Armenian (hy-am)
// author : Armendarabyan : https://github.com/armendarabyan

    (function (factory) {
        factory(moment);
    }(function (moment) {
        function monthsCaseReplace(m, format) {
            var months = {
                'nominative': '??????????????_??????????????_????????_??????????_??????????_????????????_????????????_??????????????_??????????????????_??????????????????_????????????????_??????????????????'.split('_'),
                'accusative': '????????????????_????????????????_??????????_????????????_????????????_??????????????_??????????????_????????????????_????????????????????_????????????????????_??????????????????_????????????????????'.split('_')
            },
                    nounCase = (/D[oD]?(\[[^\[\]]*\]|\s+)+MMMM?/).test(format) ?
                    'accusative' :
                    'nominative';

            return months[nounCase][m.month()];
        }

        function monthsShortCaseReplace(m, format) {
            var monthsShort = '??????_??????_??????_??????_??????_??????_??????_??????_??????_??????_??????_??????'.split('_');

            return monthsShort[m.month()];
        }

        function weekdaysCaseReplace(m, format) {
            var weekdays = '????????????_????????????????????_??????????????????_????????????????????_??????????????????_????????????_??????????'.split('_');

            return weekdays[m.day()];
        }

        return moment.defineLocale('hy-am', {
            months: monthsCaseReplace,
            monthsShort: monthsShortCaseReplace,
            weekdays: weekdaysCaseReplace,
            weekdaysShort: '??????_??????_??????_??????_??????_????????_??????'.split('_'),
            weekdaysMin: '??????_??????_??????_??????_??????_????????_??????'.split('_'),
            longDateFormat: {
                LT: 'HH:mm',
                LTS: 'LT:ss',
                L: 'DD.MM.YYYY',
                LL: 'D MMMM YYYY ??.',
                LLL: 'D MMMM YYYY ??., LT',
                LLLL: 'dddd, D MMMM YYYY ??., LT'
            },
            calendar: {
                sameDay: '[??????????] LT',
                nextDay: '[????????] LT',
                lastDay: '[????????] LT',
                nextWeek: function () {
                    return 'dddd [?????? ????????] LT';
                },
                lastWeek: function () {
                    return '[??????????] dddd [?????? ????????] LT';
                },
                sameElse: 'L'
            },
            relativeTime: {
                future: '%s ????????',
                past: '%s ????????',
                s: '???? ???????? ????????????????',
                m: '????????',
                mm: '%d ????????',
                h: '??????',
                hh: '%d ??????',
                d: '????',
                dd: '%d ????',
                M: '????????',
                MM: '%d ????????',
                y: '????????',
                yy: '%d ????????'
            },

            meridiemParse: /??????????????|????????????????|??????????????|????????????????/,
            isPM: function (input) {
                return /^(??????????????|????????????????)$/.test(input);
            },
            meridiem: function (hour) {
                if (hour < 4) {
                    return '??????????????';
                } else if (hour < 12) {
                    return '????????????????';
                } else if (hour < 17) {
                    return '??????????????';
                } else {
                    return '????????????????';
                }
            },

            ordinalParse: /\d{1,2}|\d{1,2}-(????|????)/,
            ordinal: function (number, period) {
                switch (period) {
                    case 'DDD':
                    case 'w':
                    case 'W':
                    case 'DDDo':
                        if (number === 1) {
                            return number + '-????';
                        }
                        return number + '-????';
                    default:
                        return number;
                }
            },

            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 7  // The week that contains Jan 1st is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : Bahasa Indonesia (id)
// author : Mohammad Satrio Utomo : https://github.com/tyok
// reference: http://id.wikisource.org/wiki/Pedoman_Umum_Ejaan_Bahasa_Indonesia_yang_Disempurnakan

    (function (factory) {
        factory(moment);
    }(function (moment) {
        return moment.defineLocale('id', {
            months: 'Januari_Februari_Maret_April_Mei_Juni_Juli_Agustus_September_Oktober_November_Desember'.split('_'),
            monthsShort: 'Jan_Feb_Mar_Apr_Mei_Jun_Jul_Ags_Sep_Okt_Nov_Des'.split('_'),
            weekdays: 'Minggu_Senin_Selasa_Rabu_Kamis_Jumat_Sabtu'.split('_'),
            weekdaysShort: 'Min_Sen_Sel_Rab_Kam_Jum_Sab'.split('_'),
            weekdaysMin: 'Mg_Sn_Sl_Rb_Km_Jm_Sb'.split('_'),
            longDateFormat: {
                LT: 'HH.mm',
                LTS: 'LT.ss',
                L: 'DD/MM/YYYY',
                LL: 'D MMMM YYYY',
                LLL: 'D MMMM YYYY [pukul] LT',
                LLLL: 'dddd, D MMMM YYYY [pukul] LT'
            },
            meridiemParse: /pagi|siang|sore|malam/,
            meridiemHour: function (hour, meridiem) {
                if (hour === 12) {
                    hour = 0;
                }
                if (meridiem === 'pagi') {
                    return hour;
                } else if (meridiem === 'siang') {
                    return hour >= 11 ? hour : hour + 12;
                } else if (meridiem === 'sore' || meridiem === 'malam') {
                    return hour + 12;
                }
            },
            meridiem: function (hours, minutes, isLower) {
                if (hours < 11) {
                    return 'pagi';
                } else if (hours < 15) {
                    return 'siang';
                } else if (hours < 19) {
                    return 'sore';
                } else {
                    return 'malam';
                }
            },
            calendar: {
                sameDay: '[Hari ini pukul] LT',
                nextDay: '[Besok pukul] LT',
                nextWeek: 'dddd [pukul] LT',
                lastDay: '[Kemarin pukul] LT',
                lastWeek: 'dddd [lalu pukul] LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: 'dalam %s',
                past: '%s yang lalu',
                s: 'beberapa detik',
                m: 'semenit',
                mm: '%d menit',
                h: 'sejam',
                hh: '%d jam',
                d: 'sehari',
                dd: '%d hari',
                M: 'sebulan',
                MM: '%d bulan',
                y: 'setahun',
                yy: '%d tahun'
            },
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 7  // The week that contains Jan 1st is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : icelandic (is)
// author : Hinrik ??rn Sigur??sson : https://github.com/hinrik

    (function (factory) {
        factory(moment);
    }(function (moment) {
        function plural(n) {
            if (n % 100 === 11) {
                return true;
            } else if (n % 10 === 1) {
                return false;
            }
            return true;
        }

        function translate(number, withoutSuffix, key, isFuture) {
            var result = number + ' ';
            switch (key) {
                case 's':
                    return withoutSuffix || isFuture ? 'nokkrar sek??ndur' : 'nokkrum sek??ndum';
                case 'm':
                    return withoutSuffix ? 'm??n??ta' : 'm??n??tu';
                case 'mm':
                    if (plural(number)) {
                        return result + (withoutSuffix || isFuture ? 'm??n??tur' : 'm??n??tum');
                    } else if (withoutSuffix) {
                        return result + 'm??n??ta';
                    }
                    return result + 'm??n??tu';
                case 'hh':
                    if (plural(number)) {
                        return result + (withoutSuffix || isFuture ? 'klukkustundir' : 'klukkustundum');
                    }
                    return result + 'klukkustund';
                case 'd':
                    if (withoutSuffix) {
                        return 'dagur';
                    }
                    return isFuture ? 'dag' : 'degi';
                case 'dd':
                    if (plural(number)) {
                        if (withoutSuffix) {
                            return result + 'dagar';
                        }
                        return result + (isFuture ? 'daga' : 'd??gum');
                    } else if (withoutSuffix) {
                        return result + 'dagur';
                    }
                    return result + (isFuture ? 'dag' : 'degi');
                case 'M':
                    if (withoutSuffix) {
                        return 'm??nu??ur';
                    }
                    return isFuture ? 'm??nu??' : 'm??nu??i';
                case 'MM':
                    if (plural(number)) {
                        if (withoutSuffix) {
                            return result + 'm??nu??ir';
                        }
                        return result + (isFuture ? 'm??nu??i' : 'm??nu??um');
                    } else if (withoutSuffix) {
                        return result + 'm??nu??ur';
                    }
                    return result + (isFuture ? 'm??nu??' : 'm??nu??i');
                case 'y':
                    return withoutSuffix || isFuture ? '??r' : '??ri';
                case 'yy':
                    if (plural(number)) {
                        return result + (withoutSuffix || isFuture ? '??r' : '??rum');
                    }
                    return result + (withoutSuffix || isFuture ? '??r' : '??ri');
            }
        }

        return moment.defineLocale('is', {
            months: 'jan??ar_febr??ar_mars_apr??l_ma??_j??n??_j??l??_??g??st_september_okt??ber_n??vember_desember'.split('_'),
            monthsShort: 'jan_feb_mar_apr_ma??_j??n_j??l_??g??_sep_okt_n??v_des'.split('_'),
            weekdays: 'sunnudagur_m??nudagur_??ri??judagur_mi??vikudagur_fimmtudagur_f??studagur_laugardagur'.split('_'),
            weekdaysShort: 'sun_m??n_??ri_mi??_fim_f??s_lau'.split('_'),
            weekdaysMin: 'Su_M??_??r_Mi_Fi_F??_La'.split('_'),
            longDateFormat: {
                LT: 'H:mm',
                LTS: 'LT:ss',
                L: 'DD/MM/YYYY',
                LL: 'D. MMMM YYYY',
                LLL: 'D. MMMM YYYY [kl.] LT',
                LLLL: 'dddd, D. MMMM YYYY [kl.] LT'
            },
            calendar: {
                sameDay: '[?? dag kl.] LT',
                nextDay: '[?? morgun kl.] LT',
                nextWeek: 'dddd [kl.] LT',
                lastDay: '[?? g??r kl.] LT',
                lastWeek: '[s????asta] dddd [kl.] LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: 'eftir %s',
                past: 'fyrir %s s????an',
                s: translate,
                m: translate,
                mm: translate,
                h: 'klukkustund',
                hh: translate,
                d: translate,
                dd: translate,
                M: translate,
                MM: translate,
                y: translate,
                yy: translate
            },
            ordinalParse: /\d{1,2}\./,
            ordinal: '%d.',
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 4  // The week that contains Jan 4th is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : italian (it)
// author : Lorenzo : https://github.com/aliem
// author: Mattia Larentis: https://github.com/nostalgiaz

    (function (factory) {
        factory(moment);
    }(function (moment) {
        return moment.defineLocale('it', {
            months: 'gennaio_febbraio_marzo_aprile_maggio_giugno_luglio_agosto_settembre_ottobre_novembre_dicembre'.split('_'),
            monthsShort: 'gen_feb_mar_apr_mag_giu_lug_ago_set_ott_nov_dic'.split('_'),
            weekdays: 'Domenica_Luned??_Marted??_Mercoled??_Gioved??_Venerd??_Sabato'.split('_'),
            weekdaysShort: 'Dom_Lun_Mar_Mer_Gio_Ven_Sab'.split('_'),
            weekdaysMin: 'D_L_Ma_Me_G_V_S'.split('_'),
            longDateFormat: {
                LT: 'HH:mm',
                LTS: 'LT:ss',
                L: 'DD/MM/YYYY',
                LL: 'D MMMM YYYY',
                LLL: 'D MMMM YYYY LT',
                LLLL: 'dddd, D MMMM YYYY LT'
            },
            calendar: {
                sameDay: '[Oggi alle] LT',
                nextDay: '[Domani alle] LT',
                nextWeek: 'dddd [alle] LT',
                lastDay: '[Ieri alle] LT',
                lastWeek: function () {
                    switch (this.day()) {
                        case 0:
                            return '[la scorsa] dddd [alle] LT';
                        default:
                            return '[lo scorso] dddd [alle] LT';
                    }
                },
                sameElse: 'L'
            },
            relativeTime: {
                future: function (s) {
                    return ((/^[0-9].+$/).test(s) ? 'tra' : 'in') + ' ' + s;
                },
                past: '%s fa',
                s: 'alcuni secondi',
                m: 'un minuto',
                mm: '%d minuti',
                h: 'un\'ora',
                hh: '%d ore',
                d: 'un giorno',
                dd: '%d giorni',
                M: 'un mese',
                MM: '%d mesi',
                y: 'un anno',
                yy: '%d anni'
            },
            ordinalParse: /\d{1,2}??/,
            ordinal: '%d??',
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 4  // The week that contains Jan 4th is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : japanese (ja)
// author : LI Long : https://github.com/baryon

    (function (factory) {
        factory(moment);
    }(function (moment) {
        return moment.defineLocale('ja', {
            months: '1???_2???_3???_4???_5???_6???_7???_8???_9???_10???_11???_12???'.split('_'),
            monthsShort: '1???_2???_3???_4???_5???_6???_7???_8???_9???_10???_11???_12???'.split('_'),
            weekdays: '?????????_?????????_?????????_?????????_?????????_?????????_?????????'.split('_'),
            weekdaysShort: '???_???_???_???_???_???_???'.split('_'),
            weekdaysMin: '???_???_???_???_???_???_???'.split('_'),
            longDateFormat: {
                LT: 'Ah???m???',
                LTS: 'LTs???',
                L: 'YYYY/MM/DD',
                LL: 'YYYY???M???D???',
                LLL: 'YYYY???M???D???LT',
                LLLL: 'YYYY???M???D???LT dddd'
            },
            meridiemParse: /??????|??????/i,
            isPM: function (input) {
                return input === '??????';
            },
            meridiem: function (hour, minute, isLower) {
                if (hour < 12) {
                    return '??????';
                } else {
                    return '??????';
                }
            },
            calendar: {
                sameDay: '[??????] LT',
                nextDay: '[??????] LT',
                nextWeek: '[??????]dddd LT',
                lastDay: '[??????] LT',
                lastWeek: '[??????]dddd LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: '%s???',
                past: '%s???',
                s: '??????',
                m: '1???',
                mm: '%d???',
                h: '1??????',
                hh: '%d??????',
                d: '1???',
                dd: '%d???',
                M: '1??????',
                MM: '%d??????',
                y: '1???',
                yy: '%d???'
            }
        });
    }));
// moment.js locale configuration
// locale : Georgian (ka)
// author : Irakli Janiashvili : https://github.com/irakli-janiashvili

    (function (factory) {
        factory(moment);
    }(function (moment) {
        function monthsCaseReplace(m, format) {
            var months = {
                'nominative': '?????????????????????_???????????????????????????_???????????????_??????????????????_???????????????_??????????????????_??????????????????_?????????????????????_??????????????????????????????_???????????????????????????_????????????????????????_???????????????????????????'.split('_'),
                'accusative': '?????????????????????_???????????????????????????_???????????????_?????????????????????_???????????????_??????????????????_??????????????????_?????????????????????_??????????????????????????????_???????????????????????????_????????????????????????_???????????????????????????'.split('_')
            },
                    nounCase = (/D[oD] *MMMM?/).test(format) ?
                    'accusative' :
                    'nominative';

            return months[nounCase][m.month()];
        }

        function weekdaysCaseReplace(m, format) {
            var weekdays = {
                'nominative': '???????????????_????????????????????????_???????????????????????????_???????????????????????????_???????????????????????????_???????????????????????????_??????????????????'.split('_'),
                'accusative': '??????????????????_????????????????????????_???????????????????????????_???????????????????????????_???????????????????????????_???????????????????????????_??????????????????'.split('_')
            },
                    nounCase = (/(????????????|??????????????????)/).test(format) ?
                    'accusative' :
                    'nominative';

            return weekdays[nounCase][m.day()];
        }

        return moment.defineLocale('ka', {
            months: monthsCaseReplace,
            monthsShort: '?????????_?????????_?????????_?????????_?????????_?????????_?????????_?????????_?????????_?????????_?????????_?????????'.split('_'),
            weekdays: weekdaysCaseReplace,
            weekdaysShort: '?????????_?????????_?????????_?????????_?????????_?????????_?????????'.split('_'),
            weekdaysMin: '??????_??????_??????_??????_??????_??????_??????'.split('_'),
            longDateFormat: {
                LT: 'h:mm A',
                LTS: 'h:mm:ss A',
                L: 'DD/MM/YYYY',
                LL: 'D MMMM YYYY',
                LLL: 'D MMMM YYYY LT',
                LLLL: 'dddd, D MMMM YYYY LT'
            },
            calendar: {
                sameDay: '[????????????] LT[-??????]',
                nextDay: '[????????????] LT[-??????]',
                lastDay: '[???????????????] LT[-??????]',
                nextWeek: '[??????????????????] dddd LT[-??????]',
                lastWeek: '[????????????] dddd LT-??????',
                sameElse: 'L'
            },
            relativeTime: {
                future: function (s) {
                    return (/(????????????|????????????|???????????????|????????????)/).test(s) ?
                            s.replace(/???$/, '??????') :
                            s + '??????';
                },
                past: function (s) {
                    if ((/(????????????|????????????|???????????????|?????????|?????????)/).test(s)) {
                        return s.replace(/(???|???)$/, '?????? ?????????');
                    }
                    if ((/????????????/).test(s)) {
                        return s.replace(/????????????$/, '???????????? ?????????');
                    }
                },
                s: '??????????????????????????? ????????????',
                m: '????????????',
                mm: '%d ????????????',
                h: '???????????????',
                hh: '%d ???????????????',
                d: '?????????',
                dd: '%d ?????????',
                M: '?????????',
                MM: '%d ?????????',
                y: '????????????',
                yy: '%d ????????????'
            },
            ordinalParse: /0|1-??????|??????-\d{1,2}|\d{1,2}-???/,
            ordinal: function (number) {
                if (number === 0) {
                    return number;
                }

                if (number === 1) {
                    return number + '-??????';
                }

                if ((number < 20) || (number <= 100 && (number % 20 === 0)) || (number % 100 === 0)) {
                    return '??????-' + number;
                }

                return number + '-???';
            },
            week: {
                dow: 1,
                doy: 7
            }
        });
    }));
// moment.js locale configuration
// locale : khmer (km)
// author : Kruy Vanna : https://github.com/kruyvanna

    (function (factory) {
        factory(moment);
    }(function (moment) {
        return moment.defineLocale('km', {
            months: '????????????_??????????????????_????????????_????????????_????????????_??????????????????_??????????????????_????????????_???????????????_????????????_????????????????????????_????????????'.split('_'),
            monthsShort: '????????????_??????????????????_????????????_????????????_????????????_??????????????????_??????????????????_????????????_???????????????_????????????_????????????????????????_????????????'.split('_'),
            weekdays: '?????????????????????_???????????????_??????????????????_?????????_??????????????????????????????_???????????????_????????????'.split('_'),
            weekdaysShort: '?????????????????????_???????????????_??????????????????_?????????_??????????????????????????????_???????????????_????????????'.split('_'),
            weekdaysMin: '?????????????????????_???????????????_??????????????????_?????????_??????????????????????????????_???????????????_????????????'.split('_'),
            longDateFormat: {
                LT: 'HH:mm',
                LTS: 'LT:ss',
                L: 'DD/MM/YYYY',
                LL: 'D MMMM YYYY',
                LLL: 'D MMMM YYYY LT',
                LLLL: 'dddd, D MMMM YYYY LT'
            },
            calendar: {
                sameDay: '[?????????????????? ????????????] LT',
                nextDay: '[??????????????? ????????????] LT',
                nextWeek: 'dddd [????????????] LT',
                lastDay: '[???????????????????????? ????????????] LT',
                lastWeek: 'dddd [??????????????????????????????] [????????????] LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: '%s?????????',
                past: '%s?????????',
                s: '??????????????????????????????????????????',
                m: '?????????????????????',
                mm: '%d ????????????',
                h: '?????????????????????',
                hh: '%d ????????????',
                d: '?????????????????????',
                dd: '%d ????????????',
                M: '???????????????',
                MM: '%d ??????',
                y: '????????????????????????',
                yy: '%d ???????????????'
            },
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 4 // The week that contains Jan 4th is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : korean (ko)
//
// authors
//
// - Kyungwook, Park : https://github.com/kyungw00k
// - Jeeeyul Lee <jeeeyul@gmail.com>
    (function (factory) {
        factory(moment);
    }(function (moment) {
        return moment.defineLocale('ko', {
            months: '1???_2???_3???_4???_5???_6???_7???_8???_9???_10???_11???_12???'.split('_'),
            monthsShort: '1???_2???_3???_4???_5???_6???_7???_8???_9???_10???_11???_12???'.split('_'),
            weekdays: '?????????_?????????_?????????_?????????_?????????_?????????_?????????'.split('_'),
            weekdaysShort: '???_???_???_???_???_???_???'.split('_'),
            weekdaysMin: '???_???_???_???_???_???_???'.split('_'),
            longDateFormat: {
                LT: 'A h??? m???',
                LTS: 'A h??? m??? s???',
                L: 'YYYY.MM.DD',
                LL: 'YYYY??? MMMM D???',
                LLL: 'YYYY??? MMMM D??? LT',
                LLLL: 'YYYY??? MMMM D??? dddd LT'
            },
            calendar: {
                sameDay: '?????? LT',
                nextDay: '?????? LT',
                nextWeek: 'dddd LT',
                lastDay: '?????? LT',
                lastWeek: '????????? dddd LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: '%s ???',
                past: '%s ???',
                s: '??????',
                ss: '%d???',
                m: '??????',
                mm: '%d???',
                h: '?????????',
                hh: '%d??????',
                d: '??????',
                dd: '%d???',
                M: '??????',
                MM: '%d???',
                y: '??????',
                yy: '%d???'
            },
            ordinalParse: /\d{1,2}???/,
            ordinal: '%d???',
            meridiemParse: /??????|??????/,
            isPM: function (token) {
                return token === '??????';
            },
            meridiem: function (hour, minute, isUpper) {
                return hour < 12 ? '??????' : '??????';
            }
        });
    }));
// moment.js locale configuration
// locale : Luxembourgish (lb)
// author : mweimerskirch : https://github.com/mweimerskirch, David Raison : https://github.com/kwisatz

// Note: Luxembourgish has a very particular phonological rule ('Eifeler Regel') that causes the
// deletion of the final 'n' in certain contexts. That's what the 'eifelerRegelAppliesToWeekday'
// and 'eifelerRegelAppliesToNumber' methods are meant for

    (function (factory) {
        factory(moment);
    }(function (moment) {
        function processRelativeTime(number, withoutSuffix, key, isFuture) {
            var format = {
                'm': ['eng Minutt', 'enger Minutt'],
                'h': ['eng Stonn', 'enger Stonn'],
                'd': ['een Dag', 'engem Dag'],
                'M': ['ee Mount', 'engem Mount'],
                'y': ['ee Joer', 'engem Joer']
            };
            return withoutSuffix ? format[key][0] : format[key][1];
        }

        function processFutureTime(string) {
            var number = string.substr(0, string.indexOf(' '));
            if (eifelerRegelAppliesToNumber(number)) {
                return 'a ' + string;
            }
            return 'an ' + string;
        }

        function processPastTime(string) {
            var number = string.substr(0, string.indexOf(' '));
            if (eifelerRegelAppliesToNumber(number)) {
                return 'viru ' + string;
            }
            return 'virun ' + string;
        }

        /**
         * Returns true if the word before the given number loses the '-n' ending.
         * e.g. 'an 10 Deeg' but 'a 5 Deeg'
         *
         * @param number {integer}
         * @returns {boolean}
         */
        function eifelerRegelAppliesToNumber(number) {
            number = parseInt(number, 10);
            if (isNaN(number)) {
                return false;
            }
            if (number < 0) {
                // Negative Number --> always true
                return true;
            } else if (number < 10) {
                // Only 1 digit
                if (4 <= number && number <= 7) {
                    return true;
                }
                return false;
            } else if (number < 100) {
                // 2 digits
                var lastDigit = number % 10, firstDigit = number / 10;
                if (lastDigit === 0) {
                    return eifelerRegelAppliesToNumber(firstDigit);
                }
                return eifelerRegelAppliesToNumber(lastDigit);
            } else if (number < 10000) {
                // 3 or 4 digits --> recursively check first digit
                while (number >= 10) {
                    number = number / 10;
                }
                return eifelerRegelAppliesToNumber(number);
            } else {
                // Anything larger than 4 digits: recursively check first n-3 digits
                number = number / 1000;
                return eifelerRegelAppliesToNumber(number);
            }
        }

        return moment.defineLocale('lb', {
            months: 'Januar_Februar_M??erz_Abr??ll_Mee_Juni_Juli_August_September_Oktober_November_Dezember'.split('_'),
            monthsShort: 'Jan._Febr._Mrz._Abr._Mee_Jun._Jul._Aug._Sept._Okt._Nov._Dez.'.split('_'),
            weekdays: 'Sonndeg_M??indeg_D??nschdeg_M??ttwoch_Donneschdeg_Freideg_Samschdeg'.split('_'),
            weekdaysShort: 'So._M??._D??._M??._Do._Fr._Sa.'.split('_'),
            weekdaysMin: 'So_M??_D??_M??_Do_Fr_Sa'.split('_'),
            longDateFormat: {
                LT: 'H:mm [Auer]',
                LTS: 'H:mm:ss [Auer]',
                L: 'DD.MM.YYYY',
                LL: 'D. MMMM YYYY',
                LLL: 'D. MMMM YYYY LT',
                LLLL: 'dddd, D. MMMM YYYY LT'
            },
            calendar: {
                sameDay: '[Haut um] LT',
                sameElse: 'L',
                nextDay: '[Muer um] LT',
                nextWeek: 'dddd [um] LT',
                lastDay: '[G??schter um] LT',
                lastWeek: function () {
                    // Different date string for 'D??nschdeg' (Tuesday) and 'Donneschdeg' (Thursday) due to phonological rule
                    switch (this.day()) {
                        case 2:
                        case 4:
                            return '[Leschten] dddd [um] LT';
                        default:
                            return '[Leschte] dddd [um] LT';
                    }
                }
            },
            relativeTime: {
                future: processFutureTime,
                past: processPastTime,
                s: 'e puer Sekonnen',
                m: processRelativeTime,
                mm: '%d Minutten',
                h: processRelativeTime,
                hh: '%d Stonnen',
                d: processRelativeTime,
                dd: '%d Deeg',
                M: processRelativeTime,
                MM: '%d M??int',
                y: processRelativeTime,
                yy: '%d Joer'
            },
            ordinalParse: /\d{1,2}\./,
            ordinal: '%d.',
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 4  // The week that contains Jan 4th is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : Lithuanian (lt)
// author : Mindaugas Moz??ras : https://github.com/mmozuras

    (function (factory) {
        factory(moment);
    }(function (moment) {
        var units = {
            'm': 'minut??_minut??s_minut??',
            'mm': 'minut??s_minu??i??_minutes',
            'h': 'valanda_valandos_valand??',
            'hh': 'valandos_valand??_valandas',
            'd': 'diena_dienos_dien??',
            'dd': 'dienos_dien??_dienas',
            'M': 'm??nuo_m??nesio_m??nes??',
            'MM': 'm??nesiai_m??nesi??_m??nesius',
            'y': 'metai_met??_metus',
            'yy': 'metai_met??_metus'
        },
                weekDays = 'sekmadienis_pirmadienis_antradienis_tre??iadienis_ketvirtadienis_penktadienis_??e??tadienis'.split('_');

        function translateSeconds(number, withoutSuffix, key, isFuture) {
            if (withoutSuffix) {
                return 'kelios sekund??s';
            } else {
                return isFuture ? 'keli?? sekund??i??' : 'kelias sekundes';
            }
        }

        function translateSingular(number, withoutSuffix, key, isFuture) {
            return withoutSuffix ? forms(key)[0] : (isFuture ? forms(key)[1] : forms(key)[2]);
        }

        function special(number) {
            return number % 10 === 0 || (number > 10 && number < 20);
        }

        function forms(key) {
            return units[key].split('_');
        }

        function translate(number, withoutSuffix, key, isFuture) {
            var result = number + ' ';
            if (number === 1) {
                return result + translateSingular(number, withoutSuffix, key[0], isFuture);
            } else if (withoutSuffix) {
                return result + (special(number) ? forms(key)[1] : forms(key)[0]);
            } else {
                if (isFuture) {
                    return result + forms(key)[1];
                } else {
                    return result + (special(number) ? forms(key)[1] : forms(key)[2]);
                }
            }
        }

        function relativeWeekDay(moment, format) {
            var nominative = format.indexOf('dddd HH:mm') === -1,
                    weekDay = weekDays[moment.day()];

            return nominative ? weekDay : weekDay.substring(0, weekDay.length - 2) + '??';
        }

        return moment.defineLocale('lt', {
            months: 'sausio_vasario_kovo_baland??io_gegu????s_bir??elio_liepos_rugpj????io_rugs??jo_spalio_lapkri??io_gruod??io'.split('_'),
            monthsShort: 'sau_vas_kov_bal_geg_bir_lie_rgp_rgs_spa_lap_grd'.split('_'),
            weekdays: relativeWeekDay,
            weekdaysShort: 'Sek_Pir_Ant_Tre_Ket_Pen_??e??'.split('_'),
            weekdaysMin: 'S_P_A_T_K_Pn_??'.split('_'),
            longDateFormat: {
                LT: 'HH:mm',
                LTS: 'LT:ss',
                L: 'YYYY-MM-DD',
                LL: 'YYYY [m.] MMMM D [d.]',
                LLL: 'YYYY [m.] MMMM D [d.], LT [val.]',
                LLLL: 'YYYY [m.] MMMM D [d.], dddd, LT [val.]',
                l: 'YYYY-MM-DD',
                ll: 'YYYY [m.] MMMM D [d.]',
                lll: 'YYYY [m.] MMMM D [d.], LT [val.]',
                llll: 'YYYY [m.] MMMM D [d.], ddd, LT [val.]'
            },
            calendar: {
                sameDay: '[??iandien] LT',
                nextDay: '[Rytoj] LT',
                nextWeek: 'dddd LT',
                lastDay: '[Vakar] LT',
                lastWeek: '[Pra??jus??] dddd LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: 'po %s',
                past: 'prie?? %s',
                s: translateSeconds,
                m: translateSingular,
                mm: translate,
                h: translateSingular,
                hh: translate,
                d: translateSingular,
                dd: translate,
                M: translateSingular,
                MM: translate,
                y: translateSingular,
                yy: translate
            },
            ordinalParse: /\d{1,2}-oji/,
            ordinal: function (number) {
                return number + '-oji';
            },
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 4  // The week that contains Jan 4th is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : latvian (lv)
// author : Kristaps Karlsons : https://github.com/skakri

    (function (factory) {
        factory(moment);
    }(function (moment) {
        var units = {
            'mm': 'min??ti_min??tes_min??te_min??tes',
            'hh': 'stundu_stundas_stunda_stundas',
            'dd': 'dienu_dienas_diena_dienas',
            'MM': 'm??nesi_m??ne??us_m??nesis_m??ne??i',
            'yy': 'gadu_gadus_gads_gadi'
        };

        function format(word, number, withoutSuffix) {
            var forms = word.split('_');
            if (withoutSuffix) {
                return number % 10 === 1 && number !== 11 ? forms[2] : forms[3];
            } else {
                return number % 10 === 1 && number !== 11 ? forms[0] : forms[1];
            }
        }

        function relativeTimeWithPlural(number, withoutSuffix, key) {
            return number + ' ' + format(units[key], number, withoutSuffix);
        }

        return moment.defineLocale('lv', {
            months: 'janv??ris_febru??ris_marts_apr??lis_maijs_j??nijs_j??lijs_augusts_septembris_oktobris_novembris_decembris'.split('_'),
            monthsShort: 'jan_feb_mar_apr_mai_j??n_j??l_aug_sep_okt_nov_dec'.split('_'),
            weekdays: 'sv??tdiena_pirmdiena_otrdiena_tre??diena_ceturtdiena_piektdiena_sestdiena'.split('_'),
            weekdaysShort: 'Sv_P_O_T_C_Pk_S'.split('_'),
            weekdaysMin: 'Sv_P_O_T_C_Pk_S'.split('_'),
            longDateFormat: {
                LT: 'HH:mm',
                LTS: 'LT:ss',
                L: 'DD.MM.YYYY',
                LL: 'YYYY. [gada] D. MMMM',
                LLL: 'YYYY. [gada] D. MMMM, LT',
                LLLL: 'YYYY. [gada] D. MMMM, dddd, LT'
            },
            calendar: {
                sameDay: '[??odien pulksten] LT',
                nextDay: '[R??t pulksten] LT',
                nextWeek: 'dddd [pulksten] LT',
                lastDay: '[Vakar pulksten] LT',
                lastWeek: '[Pag??ju????] dddd [pulksten] LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: '%s v??l??k',
                past: '%s agr??k',
                s: 'da??as sekundes',
                m: 'min??ti',
                mm: relativeTimeWithPlural,
                h: 'stundu',
                hh: relativeTimeWithPlural,
                d: 'dienu',
                dd: relativeTimeWithPlural,
                M: 'm??nesi',
                MM: relativeTimeWithPlural,
                y: 'gadu',
                yy: relativeTimeWithPlural
            },
            ordinalParse: /\d{1,2}\./,
            ordinal: '%d.',
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 4  // The week that contains Jan 4th is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : macedonian (mk)
// author : Borislav Mickov : https://github.com/B0k0

    (function (factory) {
        factory(moment);
    }(function (moment) {
        return moment.defineLocale('mk', {
            months: '??????????????_????????????????_????????_??????????_??????_????????_????????_????????????_??????????????????_????????????????_??????????????_????????????????'.split('_'),
            monthsShort: '??????_??????_??????_??????_??????_??????_??????_??????_??????_??????_??????_??????'.split('_'),
            weekdays: '????????????_????????????????????_??????????????_??????????_????????????????_??????????_????????????'.split('_'),
            weekdaysShort: '??????_??????_??????_??????_??????_??????_??????'.split('_'),
            weekdaysMin: '??e_??o_????_????_????_????_??a'.split('_'),
            longDateFormat: {
                LT: 'H:mm',
                LTS: 'LT:ss',
                L: 'D.MM.YYYY',
                LL: 'D MMMM YYYY',
                LLL: 'D MMMM YYYY LT',
                LLLL: 'dddd, D MMMM YYYY LT'
            },
            calendar: {
                sameDay: '[?????????? ????] LT',
                nextDay: '[???????? ????] LT',
                nextWeek: 'dddd [????] LT',
                lastDay: '[?????????? ????] LT',
                lastWeek: function () {
                    switch (this.day()) {
                        case 0:
                        case 3:
                        case 6:
                            return '[???? ????????????????????] dddd [????] LT';
                        case 1:
                        case 2:
                        case 4:
                        case 5:
                            return '[???? ????????????????????] dddd [????] LT';
                    }
                },
                sameElse: 'L'
            },
            relativeTime: {
                future: '?????????? %s',
                past: '???????? %s',
                s: '?????????????? ??????????????',
                m: '????????????',
                mm: '%d ????????????',
                h: '??????',
                hh: '%d ????????',
                d: '??????',
                dd: '%d ????????',
                M: '??????????',
                MM: '%d ????????????',
                y: '????????????',
                yy: '%d ????????????'
            },
            ordinalParse: /\d{1,2}-(????|????|????|????|????|????)/,
            ordinal: function (number) {
                var lastDigit = number % 10,
                        last2Digits = number % 100;
                if (number === 0) {
                    return number + '-????';
                } else if (last2Digits === 0) {
                    return number + '-????';
                } else if (last2Digits > 10 && last2Digits < 20) {
                    return number + '-????';
                } else if (lastDigit === 1) {
                    return number + '-????';
                } else if (lastDigit === 2) {
                    return number + '-????';
                } else if (lastDigit === 7 || lastDigit === 8) {
                    return number + '-????';
                } else {
                    return number + '-????';
                }
            },
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 7  // The week that contains Jan 1st is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : malayalam (ml)
// author : Floyd Pink : https://github.com/floydpink

    (function (factory) {
        factory(moment);
    }(function (moment) {
        return moment.defineLocale('ml', {
            months: '??????????????????_???????????????????????????_?????????????????????_??????????????????_????????????_?????????_????????????_????????????????????????_??????????????????????????????_?????????????????????_???????????????_??????????????????'.split('_'),
            monthsShort: '?????????._??????????????????._?????????._???????????????._????????????_?????????_????????????._??????._?????????????????????._???????????????._?????????._????????????.'.split('_'),
            weekdays: '????????????????????????_??????????????????????????????_???????????????????????????_????????????????????????_???????????????????????????_?????????????????????????????????_????????????????????????'.split('_'),
            weekdaysShort: '????????????_??????????????????_???????????????_????????????_??????????????????_??????????????????_?????????'.split('_'),
            weekdaysMin: '??????_??????_??????_??????_????????????_??????_???'.split('_'),
            longDateFormat: {
                LT: 'A h:mm -??????',
                LTS: 'A h:mm:ss -??????',
                L: 'DD/MM/YYYY',
                LL: 'D MMMM YYYY',
                LLL: 'D MMMM YYYY, LT',
                LLLL: 'dddd, D MMMM YYYY, LT'
            },
            calendar: {
                sameDay: '[???????????????] LT',
                nextDay: '[????????????] LT',
                nextWeek: 'dddd, LT',
                lastDay: '[??????????????????] LT',
                lastWeek: '[??????????????????] dddd, LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: '%s ?????????????????????',
                past: '%s ???????????????',
                s: '????????? ???????????????????????????',
                m: '????????? ????????????????????????',
                mm: '%d ????????????????????????',
                h: '????????? ????????????????????????',
                hh: '%d ????????????????????????',
                d: '????????? ???????????????',
                dd: '%d ???????????????',
                M: '????????? ????????????',
                MM: '%d ????????????',
                y: '????????? ????????????',
                yy: '%d ????????????'
            },
            meridiemParse: /??????????????????|??????????????????|???????????? ?????????????????????|??????????????????????????????|??????????????????/i,
            isPM: function (input) {
                return /^(???????????? ?????????????????????|??????????????????????????????|??????????????????)$/.test(input);
            },
            meridiem: function (hour, minute, isLower) {
                if (hour < 4) {
                    return '??????????????????';
                } else if (hour < 12) {
                    return '??????????????????';
                } else if (hour < 17) {
                    return '???????????? ?????????????????????';
                } else if (hour < 20) {
                    return '??????????????????????????????';
                } else {
                    return '??????????????????';
                }
            }
        });
    }));
// moment.js locale configuration
// locale : Marathi (mr)
// author : Harshad Kale : https://github.com/kalehv

    (function (factory) {
        factory(moment);
    }(function (moment) {
        var symbolMap = {
            '1': '???',
            '2': '???',
            '3': '???',
            '4': '???',
            '5': '???',
            '6': '???',
            '7': '???',
            '8': '???',
            '9': '???',
            '0': '???'
        },
                numberMap = {
                    '???': '1',
                    '???': '2',
                    '???': '3',
                    '???': '4',
                    '???': '5',
                    '???': '6',
                    '???': '7',
                    '???': '8',
                    '???': '9',
                    '???': '0'
                };

        return moment.defineLocale('mr', {
            months: '????????????????????????_??????????????????????????????_???????????????_??????????????????_??????_?????????_????????????_???????????????_????????????????????????_?????????????????????_???????????????????????????_?????????????????????'.split('_'),
            monthsShort: '????????????._??????????????????._???????????????._???????????????._??????._?????????._????????????._??????._??????????????????._???????????????._?????????????????????._???????????????.'.split('_'),
            weekdays: '??????????????????_??????????????????_?????????????????????_??????????????????_?????????????????????_????????????????????????_??????????????????'.split('_'),
            weekdaysShort: '?????????_?????????_????????????_?????????_????????????_???????????????_?????????'.split('_'),
            weekdaysMin: '???_??????_??????_??????_??????_??????_???'.split('_'),
            longDateFormat: {
                LT: 'A h:mm ???????????????',
                LTS: 'A h:mm:ss ???????????????',
                L: 'DD/MM/YYYY',
                LL: 'D MMMM YYYY',
                LLL: 'D MMMM YYYY, LT',
                LLLL: 'dddd, D MMMM YYYY, LT'
            },
            calendar: {
                sameDay: '[??????] LT',
                nextDay: '[???????????????] LT',
                nextWeek: 'dddd, LT',
                lastDay: '[?????????] LT',
                lastWeek: '[???????????????] dddd, LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: '%s ????????????',
                past: '%s ??????????????????',
                s: '???????????????',
                m: '?????? ???????????????',
                mm: '%d ??????????????????',
                h: '?????? ?????????',
                hh: '%d ?????????',
                d: '?????? ????????????',
                dd: '%d ????????????',
                M: '?????? ???????????????',
                MM: '%d ???????????????',
                y: '?????? ????????????',
                yy: '%d ???????????????'
            },
            preparse: function (string) {
                return string.replace(/[??????????????????????????????]/g, function (match) {
                    return numberMap[match];
                });
            },
            postformat: function (string) {
                return string.replace(/\d/g, function (match) {
                    return symbolMap[match];
                });
            },
            meridiemParse: /??????????????????|???????????????|??????????????????|????????????????????????/,
            meridiemHour: function (hour, meridiem) {
                if (hour === 12) {
                    hour = 0;
                }
                if (meridiem === '??????????????????') {
                    return hour < 4 ? hour : hour + 12;
                } else if (meridiem === '???????????????') {
                    return hour;
                } else if (meridiem === '??????????????????') {
                    return hour >= 10 ? hour : hour + 12;
                } else if (meridiem === '????????????????????????') {
                    return hour + 12;
                }
            },
            meridiem: function (hour, minute, isLower)
            {
                if (hour < 4) {
                    return '??????????????????';
                } else if (hour < 10) {
                    return '???????????????';
                } else if (hour < 17) {
                    return '??????????????????';
                } else if (hour < 20) {
                    return '????????????????????????';
                } else {
                    return '??????????????????';
                }
            },
            week: {
                dow: 0, // Sunday is the first day of the week.
                doy: 6  // The week that contains Jan 1st is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : Bahasa Malaysia (ms-MY)
// author : Weldan Jamili : https://github.com/weldan

    (function (factory) {
        factory(moment);
    }(function (moment) {
        return moment.defineLocale('ms-my', {
            months: 'Januari_Februari_Mac_April_Mei_Jun_Julai_Ogos_September_Oktober_November_Disember'.split('_'),
            monthsShort: 'Jan_Feb_Mac_Apr_Mei_Jun_Jul_Ogs_Sep_Okt_Nov_Dis'.split('_'),
            weekdays: 'Ahad_Isnin_Selasa_Rabu_Khamis_Jumaat_Sabtu'.split('_'),
            weekdaysShort: 'Ahd_Isn_Sel_Rab_Kha_Jum_Sab'.split('_'),
            weekdaysMin: 'Ah_Is_Sl_Rb_Km_Jm_Sb'.split('_'),
            longDateFormat: {
                LT: 'HH.mm',
                LTS: 'LT.ss',
                L: 'DD/MM/YYYY',
                LL: 'D MMMM YYYY',
                LLL: 'D MMMM YYYY [pukul] LT',
                LLLL: 'dddd, D MMMM YYYY [pukul] LT'
            },
            meridiemParse: /pagi|tengahari|petang|malam/,
            meridiemHour: function (hour, meridiem) {
                if (hour === 12) {
                    hour = 0;
                }
                if (meridiem === 'pagi') {
                    return hour;
                } else if (meridiem === 'tengahari') {
                    return hour >= 11 ? hour : hour + 12;
                } else if (meridiem === 'petang' || meridiem === 'malam') {
                    return hour + 12;
                }
            },
            meridiem: function (hours, minutes, isLower) {
                if (hours < 11) {
                    return 'pagi';
                } else if (hours < 15) {
                    return 'tengahari';
                } else if (hours < 19) {
                    return 'petang';
                } else {
                    return 'malam';
                }
            },
            calendar: {
                sameDay: '[Hari ini pukul] LT',
                nextDay: '[Esok pukul] LT',
                nextWeek: 'dddd [pukul] LT',
                lastDay: '[Kelmarin pukul] LT',
                lastWeek: 'dddd [lepas pukul] LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: 'dalam %s',
                past: '%s yang lepas',
                s: 'beberapa saat',
                m: 'seminit',
                mm: '%d minit',
                h: 'sejam',
                hh: '%d jam',
                d: 'sehari',
                dd: '%d hari',
                M: 'sebulan',
                MM: '%d bulan',
                y: 'setahun',
                yy: '%d tahun'
            },
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 7  // The week that contains Jan 1st is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : Burmese (my)
// author : Squar team, mysquar.com

    (function (factory) {
        factory(moment);
    }(function (moment) {
        var symbolMap = {
            '1': '???',
            '2': '???',
            '3': '???',
            '4': '???',
            '5': '???',
            '6': '???',
            '7': '???',
            '8': '???',
            '9': '???',
            '0': '???'
        }, numberMap = {
            '???': '1',
            '???': '2',
            '???': '3',
            '???': '4',
            '???': '5',
            '???': '6',
            '???': '7',
            '???': '8',
            '???': '9',
            '???': '0'
        };
        return moment.defineLocale('my', {
            months: '????????????????????????_??????????????????????????????_?????????_????????????_??????_????????????_?????????????????????_??????????????????_????????????????????????_??????????????????????????????_????????????????????????_?????????????????????'.split('_'),
            monthsShort: '?????????_??????_?????????_?????????_??????_????????????_???????????????_??????_?????????_???????????????_?????????_??????'.split('_'),
            weekdays: '???????????????????????????_?????????????????????_??????????????????_????????????????????????_????????????????????????_??????????????????_?????????'.split('_'),
            weekdaysShort: '?????????_??????_???????????????_?????????_?????????_?????????_??????'.split('_'),
            weekdaysMin: '?????????_??????_???????????????_?????????_?????????_?????????_??????'.split('_'),
            longDateFormat: {
                LT: 'HH:mm',
                LTS: 'HH:mm:ss',
                L: 'DD/MM/YYYY',
                LL: 'D MMMM YYYY',
                LLL: 'D MMMM YYYY LT',
                LLLL: 'dddd D MMMM YYYY LT'
            },
            calendar: {
                sameDay: '[?????????.] LT [?????????]',
                nextDay: '[????????????????????????] LT [?????????]',
                nextWeek: 'dddd LT [?????????]',
                lastDay: '[?????????.???] LT [?????????]',
                lastWeek: '[??????????????????????????????] dddd LT [?????????]',
                sameElse: 'L'
            },
            relativeTime: {
                future: '?????????????????? %s ?????????',
                past: '?????????????????????????????? %s ???',
                s: '??????????????????.????????????????????????',
                m: '????????????????????????',
                mm: '%d ???????????????',
                h: '?????????????????????',
                hh: '%d ????????????',
                d: '??????????????????',
                dd: '%d ?????????',
                M: '????????????',
                MM: '%d ???',
                y: '?????????????????????',
                yy: '%d ????????????'
            },
            preparse: function (string) {
                return string.replace(/[??????????????????????????????]/g, function (match) {
                    return numberMap[match];
                });
            },
            postformat: function (string) {
                return string.replace(/\d/g, function (match) {
                    return symbolMap[match];
                });
            },
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 4 // The week that contains Jan 1st is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : norwegian bokm??l (nb)
// authors : Espen Hovlandsdal : https://github.com/rexxars
//           Sigurd Gartmann : https://github.com/sigurdga

    (function (factory) {
        factory(moment);
    }(function (moment) {
        return moment.defineLocale('nb', {
            months: 'januar_februar_mars_april_mai_juni_juli_august_september_oktober_november_desember'.split('_'),
            monthsShort: 'jan_feb_mar_apr_mai_jun_jul_aug_sep_okt_nov_des'.split('_'),
            weekdays: 's??ndag_mandag_tirsdag_onsdag_torsdag_fredag_l??rdag'.split('_'),
            weekdaysShort: 's??n_man_tirs_ons_tors_fre_l??r'.split('_'),
            weekdaysMin: 's??_ma_ti_on_to_fr_l??'.split('_'),
            longDateFormat: {
                LT: 'H.mm',
                LTS: 'LT.ss',
                L: 'DD.MM.YYYY',
                LL: 'D. MMMM YYYY',
                LLL: 'D. MMMM YYYY [kl.] LT',
                LLLL: 'dddd D. MMMM YYYY [kl.] LT'
            },
            calendar: {
                sameDay: '[i dag kl.] LT',
                nextDay: '[i morgen kl.] LT',
                nextWeek: 'dddd [kl.] LT',
                lastDay: '[i g??r kl.] LT',
                lastWeek: '[forrige] dddd [kl.] LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: 'om %s',
                past: 'for %s siden',
                s: 'noen sekunder',
                m: 'ett minutt',
                mm: '%d minutter',
                h: 'en time',
                hh: '%d timer',
                d: 'en dag',
                dd: '%d dager',
                M: 'en m??ned',
                MM: '%d m??neder',
                y: 'ett ??r',
                yy: '%d ??r'
            },
            ordinalParse: /\d{1,2}\./,
            ordinal: '%d.',
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 4  // The week that contains Jan 4th is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : nepali/nepalese
// author : suvash : https://github.com/suvash

    (function (factory) {
        factory(moment);
    }(function (moment) {
        var symbolMap = {
            '1': '???',
            '2': '???',
            '3': '???',
            '4': '???',
            '5': '???',
            '6': '???',
            '7': '???',
            '8': '???',
            '9': '???',
            '0': '???'
        },
                numberMap = {
                    '???': '1',
                    '???': '2',
                    '???': '3',
                    '???': '4',
                    '???': '5',
                    '???': '6',
                    '???': '7',
                    '???': '8',
                    '???': '9',
                    '???': '0'
                };

        return moment.defineLocale('ne', {
            months: '???????????????_???????????????????????????_???????????????_??????????????????_??????_?????????_???????????????_???????????????_??????????????????????????????_?????????????????????_????????????????????????_????????????????????????'.split('_'),
            monthsShort: '??????._??????????????????._???????????????_???????????????._??????_?????????_???????????????._??????._???????????????._???????????????._????????????._????????????.'.split('_'),
            weekdays: '??????????????????_??????????????????_????????????????????????_??????????????????_?????????????????????_????????????????????????_??????????????????'.split('_'),
            weekdaysShort: '?????????._?????????._???????????????._?????????._????????????._???????????????._?????????.'.split('_'),
            weekdaysMin: '??????._??????._?????????_??????._??????._??????._???.'.split('_'),
            longDateFormat: {
                LT: 'A?????? h:mm ?????????',
                LTS: 'A?????? h:mm:ss ?????????',
                L: 'DD/MM/YYYY',
                LL: 'D MMMM YYYY',
                LLL: 'D MMMM YYYY, LT',
                LLLL: 'dddd, D MMMM YYYY, LT'
            },
            preparse: function (string) {
                return string.replace(/[??????????????????????????????]/g, function (match) {
                    return numberMap[match];
                });
            },
            postformat: function (string) {
                return string.replace(/\d/g, function (match) {
                    return symbolMap[match];
                });
            },
            meridiemParse: /????????????|???????????????|??????????????????|??????????????????|????????????|????????????/,
            meridiemHour: function (hour, meridiem) {
                if (hour === 12) {
                    hour = 0;
                }
                if (meridiem === '????????????') {
                    return hour < 3 ? hour : hour + 12;
                } else if (meridiem === '???????????????') {
                    return hour;
                } else if (meridiem === '??????????????????') {
                    return hour >= 10 ? hour : hour + 12;
                } else if (meridiem === '??????????????????' || meridiem === '????????????') {
                    return hour + 12;
                }
            },
            meridiem: function (hour, minute, isLower) {
                if (hour < 3) {
                    return '????????????';
                } else if (hour < 10) {
                    return '???????????????';
                } else if (hour < 15) {
                    return '??????????????????';
                } else if (hour < 18) {
                    return '??????????????????';
                } else if (hour < 20) {
                    return '????????????';
                } else {
                    return '????????????';
                }
            },
            calendar: {
                sameDay: '[??????] LT',
                nextDay: '[????????????] LT',
                nextWeek: '[???????????????] dddd[,] LT',
                lastDay: '[????????????] LT',
                lastWeek: '[????????????] dddd[,] LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: '%s??????',
                past: '%s ???????????????',
                s: '???????????? ?????????',
                m: '?????? ???????????????',
                mm: '%d ???????????????',
                h: '?????? ???????????????',
                hh: '%d ???????????????',
                d: '?????? ?????????',
                dd: '%d ?????????',
                M: '?????? ???????????????',
                MM: '%d ???????????????',
                y: '?????? ????????????',
                yy: '%d ????????????'
            },
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 7  // The week that contains Jan 1st is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : dutch (nl)
// author : Joris R??ling : https://github.com/jjupiter

    (function (factory) {
        factory(moment);
    }(function (moment) {
        var monthsShortWithDots = 'jan._feb._mrt._apr._mei_jun._jul._aug._sep._okt._nov._dec.'.split('_'),
                monthsShortWithoutDots = 'jan_feb_mrt_apr_mei_jun_jul_aug_sep_okt_nov_dec'.split('_');

        return moment.defineLocale('nl', {
            months: 'januari_februari_maart_april_mei_juni_juli_augustus_september_oktober_november_december'.split('_'),
            monthsShort: function (m, format) {
                if (/-MMM-/.test(format)) {
                    return monthsShortWithoutDots[m.month()];
                } else {
                    return monthsShortWithDots[m.month()];
                }
            },
            weekdays: 'zondag_maandag_dinsdag_woensdag_donderdag_vrijdag_zaterdag'.split('_'),
            weekdaysShort: 'zo._ma._di._wo._do._vr._za.'.split('_'),
            weekdaysMin: 'Zo_Ma_Di_Wo_Do_Vr_Za'.split('_'),
            longDateFormat: {
                LT: 'HH:mm',
                LTS: 'LT:ss',
                L: 'DD-MM-YYYY',
                LL: 'D MMMM YYYY',
                LLL: 'D MMMM YYYY LT',
                LLLL: 'dddd D MMMM YYYY LT'
            },
            calendar: {
                sameDay: '[vandaag om] LT',
                nextDay: '[morgen om] LT',
                nextWeek: 'dddd [om] LT',
                lastDay: '[gisteren om] LT',
                lastWeek: '[afgelopen] dddd [om] LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: 'over %s',
                past: '%s geleden',
                s: 'een paar seconden',
                m: '????n minuut',
                mm: '%d minuten',
                h: '????n uur',
                hh: '%d uur',
                d: '????n dag',
                dd: '%d dagen',
                M: '????n maand',
                MM: '%d maanden',
                y: '????n jaar',
                yy: '%d jaar'
            },
            ordinalParse: /\d{1,2}(ste|de)/,
            ordinal: function (number) {
                return number + ((number === 1 || number === 8 || number >= 20) ? 'ste' : 'de');
            },
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 4  // The week that contains Jan 4th is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : norwegian nynorsk (nn)
// author : https://github.com/mechuwind

    (function (factory) {
        factory(moment);
    }(function (moment) {
        return moment.defineLocale('nn', {
            months: 'januar_februar_mars_april_mai_juni_juli_august_september_oktober_november_desember'.split('_'),
            monthsShort: 'jan_feb_mar_apr_mai_jun_jul_aug_sep_okt_nov_des'.split('_'),
            weekdays: 'sundag_m??ndag_tysdag_onsdag_torsdag_fredag_laurdag'.split('_'),
            weekdaysShort: 'sun_m??n_tys_ons_tor_fre_lau'.split('_'),
            weekdaysMin: 'su_m??_ty_on_to_fr_l??'.split('_'),
            longDateFormat: {
                LT: 'HH:mm',
                LTS: 'LT:ss',
                L: 'DD.MM.YYYY',
                LL: 'D MMMM YYYY',
                LLL: 'D MMMM YYYY LT',
                LLLL: 'dddd D MMMM YYYY LT'
            },
            calendar: {
                sameDay: '[I dag klokka] LT',
                nextDay: '[I morgon klokka] LT',
                nextWeek: 'dddd [klokka] LT',
                lastDay: '[I g??r klokka] LT',
                lastWeek: '[F??reg??ande] dddd [klokka] LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: 'om %s',
                past: 'for %s sidan',
                s: 'nokre sekund',
                m: 'eit minutt',
                mm: '%d minutt',
                h: 'ein time',
                hh: '%d timar',
                d: 'ein dag',
                dd: '%d dagar',
                M: 'ein m??nad',
                MM: '%d m??nader',
                y: 'eit ??r',
                yy: '%d ??r'
            },
            ordinalParse: /\d{1,2}\./,
            ordinal: '%d.',
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 4  // The week that contains Jan 4th is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : polish (pl)
// author : Rafal Hirsz : https://github.com/evoL

    (function (factory) {
        factory(moment);
    }(function (moment) {
        var monthsNominative = 'stycze??_luty_marzec_kwiecie??_maj_czerwiec_lipiec_sierpie??_wrzesie??_pa??dziernik_listopad_grudzie??'.split('_'),
                monthsSubjective = 'stycznia_lutego_marca_kwietnia_maja_czerwca_lipca_sierpnia_wrze??nia_pa??dziernika_listopada_grudnia'.split('_');

        function plural(n) {
            return (n % 10 < 5) && (n % 10 > 1) && ((~~(n / 10) % 10) !== 1);
        }

        function translate(number, withoutSuffix, key) {
            var result = number + ' ';
            switch (key) {
                case 'm':
                    return withoutSuffix ? 'minuta' : 'minut??';
                case 'mm':
                    return result + (plural(number) ? 'minuty' : 'minut');
                case 'h':
                    return withoutSuffix ? 'godzina' : 'godzin??';
                case 'hh':
                    return result + (plural(number) ? 'godziny' : 'godzin');
                case 'MM':
                    return result + (plural(number) ? 'miesi??ce' : 'miesi??cy');
                case 'yy':
                    return result + (plural(number) ? 'lata' : 'lat');
            }
        }

        return moment.defineLocale('pl', {
            months: function (momentToFormat, format) {
                if (/D MMMM/.test(format)) {
                    return monthsSubjective[momentToFormat.month()];
                } else {
                    return monthsNominative[momentToFormat.month()];
                }
            },
            monthsShort: 'sty_lut_mar_kwi_maj_cze_lip_sie_wrz_pa??_lis_gru'.split('_'),
            weekdays: 'niedziela_poniedzia??ek_wtorek_??roda_czwartek_pi??tek_sobota'.split('_'),
            weekdaysShort: 'nie_pon_wt_??r_czw_pt_sb'.split('_'),
            weekdaysMin: 'N_Pn_Wt_??r_Cz_Pt_So'.split('_'),
            longDateFormat: {
                LT: 'HH:mm',
                LTS: 'LT:ss',
                L: 'DD.MM.YYYY',
                LL: 'D MMMM YYYY',
                LLL: 'D MMMM YYYY LT',
                LLLL: 'dddd, D MMMM YYYY LT'
            },
            calendar: {
                sameDay: '[Dzi?? o] LT',
                nextDay: '[Jutro o] LT',
                nextWeek: '[W] dddd [o] LT',
                lastDay: '[Wczoraj o] LT',
                lastWeek: function () {
                    switch (this.day()) {
                        case 0:
                            return '[W zesz???? niedziel?? o] LT';
                        case 3:
                            return '[W zesz???? ??rod?? o] LT';
                        case 6:
                            return '[W zesz???? sobot?? o] LT';
                        default:
                            return '[W zesz??y] dddd [o] LT';
                    }
                },
                sameElse: 'L'
            },
            relativeTime: {
                future: 'za %s',
                past: '%s temu',
                s: 'kilka sekund',
                m: translate,
                mm: translate,
                h: translate,
                hh: translate,
                d: '1 dzie??',
                dd: '%d dni',
                M: 'miesi??c',
                MM: translate,
                y: 'rok',
                yy: translate
            },
            ordinalParse: /\d{1,2}\./,
            ordinal: '%d.',
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 4  // The week that contains Jan 4th is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : brazilian portuguese (pt-br)
// author : Caio Ribeiro Pereira : https://github.com/caio-ribeiro-pereira

    (function (factory) {
        factory(moment);
    }(function (moment) {
        return moment.defineLocale('pt-br', {
            months: 'janeiro_fevereiro_mar??o_abril_maio_junho_julho_agosto_setembro_outubro_novembro_dezembro'.split('_'),
            monthsShort: 'jan_fev_mar_abr_mai_jun_jul_ago_set_out_nov_dez'.split('_'),
            weekdays: 'domingo_segunda-feira_ter??a-feira_quarta-feira_quinta-feira_sexta-feira_s??bado'.split('_'),
            weekdaysShort: 'dom_seg_ter_qua_qui_sex_s??b'.split('_'),
            weekdaysMin: 'dom_2??_3??_4??_5??_6??_s??b'.split('_'),
            longDateFormat: {
                LT: 'HH:mm',
                LTS: 'LT:ss',
                L: 'DD/MM/YYYY',
                LL: 'D [de] MMMM [de] YYYY',
                LLL: 'D [de] MMMM [de] YYYY [??s] LT',
                LLLL: 'dddd, D [de] MMMM [de] YYYY [??s] LT'
            },
            calendar: {
                sameDay: '[Hoje ??s] LT',
                nextDay: '[Amanh?? ??s] LT',
                nextWeek: 'dddd [??s] LT',
                lastDay: '[Ontem ??s] LT',
                lastWeek: function () {
                    return (this.day() === 0 || this.day() === 6) ?
                            '[??ltimo] dddd [??s] LT' : // Saturday + Sunday
                            '[??ltima] dddd [??s] LT'; // Monday - Friday
                },
                sameElse: 'L'
            },
            relativeTime: {
                future: 'em %s',
                past: '%s atr??s',
                s: 'segundos',
                m: 'um minuto',
                mm: '%d minutos',
                h: 'uma hora',
                hh: '%d horas',
                d: 'um dia',
                dd: '%d dias',
                M: 'um m??s',
                MM: '%d meses',
                y: 'um ano',
                yy: '%d anos'
            },
            ordinalParse: /\d{1,2}??/,
            ordinal: '%d??'
        });
    }));
// moment.js locale configuration
// locale : portuguese (pt)
// author : Jefferson : https://github.com/jalex79

    (function (factory) {
        factory(moment);
    }(function (moment) {
        return moment.defineLocale('pt', {
            months: 'janeiro_fevereiro_mar??o_abril_maio_junho_julho_agosto_setembro_outubro_novembro_dezembro'.split('_'),
            monthsShort: 'jan_fev_mar_abr_mai_jun_jul_ago_set_out_nov_dez'.split('_'),
            weekdays: 'domingo_segunda-feira_ter??a-feira_quarta-feira_quinta-feira_sexta-feira_s??bado'.split('_'),
            weekdaysShort: 'dom_seg_ter_qua_qui_sex_s??b'.split('_'),
            weekdaysMin: 'dom_2??_3??_4??_5??_6??_s??b'.split('_'),
            longDateFormat: {
                LT: 'HH:mm',
                LTS: 'LT:ss',
                L: 'DD/MM/YYYY',
                LL: 'D [de] MMMM [de] YYYY',
                LLL: 'D [de] MMMM [de] YYYY LT',
                LLLL: 'dddd, D [de] MMMM [de] YYYY LT'
            },
            calendar: {
                sameDay: '[Hoje ??s] LT',
                nextDay: '[Amanh?? ??s] LT',
                nextWeek: 'dddd [??s] LT',
                lastDay: '[Ontem ??s] LT',
                lastWeek: function () {
                    return (this.day() === 0 || this.day() === 6) ?
                            '[??ltimo] dddd [??s] LT' : // Saturday + Sunday
                            '[??ltima] dddd [??s] LT'; // Monday - Friday
                },
                sameElse: 'L'
            },
            relativeTime: {
                future: 'em %s',
                past: 'h?? %s',
                s: 'segundos',
                m: 'um minuto',
                mm: '%d minutos',
                h: 'uma hora',
                hh: '%d horas',
                d: 'um dia',
                dd: '%d dias',
                M: 'um m??s',
                MM: '%d meses',
                y: 'um ano',
                yy: '%d anos'
            },
            ordinalParse: /\d{1,2}??/,
            ordinal: '%d??',
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 4  // The week that contains Jan 4th is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : romanian (ro)
// author : Vlad Gurdiga : https://github.com/gurdiga
// author : Valentin Agachi : https://github.com/avaly

    (function (factory) {
        factory(moment);
    }(function (moment) {
        function relativeTimeWithPlural(number, withoutSuffix, key) {
            var format = {
                'mm': 'minute',
                'hh': 'ore',
                'dd': 'zile',
                'MM': 'luni',
                'yy': 'ani'
            },
                    separator = ' ';
            if (number % 100 >= 20 || (number >= 100 && number % 100 === 0)) {
                separator = ' de ';
            }

            return number + separator + format[key];
        }

        return moment.defineLocale('ro', {
            months: 'ianuarie_februarie_martie_aprilie_mai_iunie_iulie_august_septembrie_octombrie_noiembrie_decembrie'.split('_'),
            monthsShort: 'ian._febr._mart._apr._mai_iun._iul._aug._sept._oct._nov._dec.'.split('_'),
            weekdays: 'duminic??_luni_mar??i_miercuri_joi_vineri_s??mb??t??'.split('_'),
            weekdaysShort: 'Dum_Lun_Mar_Mie_Joi_Vin_S??m'.split('_'),
            weekdaysMin: 'Du_Lu_Ma_Mi_Jo_Vi_S??'.split('_'),
            longDateFormat: {
                LT: 'H:mm',
                LTS: 'LT:ss',
                L: 'DD.MM.YYYY',
                LL: 'D MMMM YYYY',
                LLL: 'D MMMM YYYY H:mm',
                LLLL: 'dddd, D MMMM YYYY H:mm'
            },
            calendar: {
                sameDay: '[azi la] LT',
                nextDay: '[m??ine la] LT',
                nextWeek: 'dddd [la] LT',
                lastDay: '[ieri la] LT',
                lastWeek: '[fosta] dddd [la] LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: 'peste %s',
                past: '%s ??n urm??',
                s: 'c??teva secunde',
                m: 'un minut',
                mm: relativeTimeWithPlural,
                h: 'o or??',
                hh: relativeTimeWithPlural,
                d: 'o zi',
                dd: relativeTimeWithPlural,
                M: 'o lun??',
                MM: relativeTimeWithPlural,
                y: 'un an',
                yy: relativeTimeWithPlural
            },
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 7  // The week that contains Jan 1st is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : russian (ru)
// author : Viktorminator : https://github.com/Viktorminator
// Author : Menelion Elens??le : https://github.com/Oire

    (function (factory) {
        factory(moment);
    }(function (moment) {
        function plural(word, num) {
            var forms = word.split('_');
            return num % 10 === 1 && num % 100 !== 11 ? forms[0] : (num % 10 >= 2 && num % 10 <= 4 && (num % 100 < 10 || num % 100 >= 20) ? forms[1] : forms[2]);
        }

        function relativeTimeWithPlural(number, withoutSuffix, key) {
            var format = {
                'mm': withoutSuffix ? '????????????_????????????_??????????' : '????????????_????????????_??????????',
                'hh': '??????_????????_??????????',
                'dd': '????????_??????_????????',
                'MM': '??????????_????????????_??????????????',
                'yy': '??????_????????_??????'
            };
            if (key === 'm') {
                return withoutSuffix ? '????????????' : '????????????';
            } else {
                return number + ' ' + plural(format[key], +number);
            }
        }

        function monthsCaseReplace(m, format) {
            var months = {
                'nominative': '????????????_??????????????_????????_????????????_??????_????????_????????_????????????_????????????????_??????????????_????????????_??????????????'.split('_'),
                'accusative': '????????????_??????????????_??????????_????????????_??????_????????_????????_??????????????_????????????????_??????????????_????????????_??????????????'.split('_')
            },
                    nounCase = (/D[oD]?(\[[^\[\]]*\]|\s+)+MMMM?/).test(format) ?
                    'accusative' :
                    'nominative';

            return months[nounCase][m.month()];
        }

        function monthsShortCaseReplace(m, format) {
            var monthsShort = {
                'nominative': '??????_??????_????????_??????_??????_????????_????????_??????_??????_??????_??????_??????'.split('_'),
                'accusative': '??????_??????_??????_??????_??????_????????_????????_??????_??????_??????_??????_??????'.split('_')
            },
                    nounCase = (/D[oD]?(\[[^\[\]]*\]|\s+)+MMMM?/).test(format) ?
                    'accusative' :
                    'nominative';

            return monthsShort[nounCase][m.month()];
        }

        function weekdaysCaseReplace(m, format) {
            var weekdays = {
                'nominative': '??????????????????????_??????????????????????_??????????????_??????????_??????????????_??????????????_??????????????'.split('_'),
                'accusative': '??????????????????????_??????????????????????_??????????????_??????????_??????????????_??????????????_??????????????'.split('_')
            },
                    nounCase = (/\[ ?[????] ?(?:??????????????|??????????????????|??????)? ?\] ?dddd/).test(format) ?
                    'accusative' :
                    'nominative';

            return weekdays[nounCase][m.day()];
        }

        return moment.defineLocale('ru', {
            months: monthsCaseReplace,
            monthsShort: monthsShortCaseReplace,
            weekdays: weekdaysCaseReplace,
            weekdaysShort: '????_????_????_????_????_????_????'.split('_'),
            weekdaysMin: '????_????_????_????_????_????_????'.split('_'),
            monthsParse: [/^??????/i, /^??????/i, /^??????/i, /^??????/i, /^????[??|??]/i, /^??????/i, /^??????/i, /^??????/i, /^??????/i, /^??????/i, /^??????/i, /^??????/i],
            longDateFormat: {
                LT: 'HH:mm',
                LTS: 'LT:ss',
                L: 'DD.MM.YYYY',
                LL: 'D MMMM YYYY ??.',
                LLL: 'D MMMM YYYY ??., LT',
                LLLL: 'dddd, D MMMM YYYY ??., LT'
            },
            calendar: {
                sameDay: '[?????????????? ??] LT',
                nextDay: '[???????????? ??] LT',
                lastDay: '[?????????? ??] LT',
                nextWeek: function () {
                    return this.day() === 2 ? '[????] dddd [??] LT' : '[??] dddd [??] LT';
                },
                lastWeek: function (now) {
                    if (now.week() !== this.week()) {
                        switch (this.day()) {
                            case 0:
                                return '[?? ??????????????] dddd [??] LT';
                            case 1:
                            case 2:
                            case 4:
                                return '[?? ??????????????] dddd [??] LT';
                            case 3:
                            case 5:
                            case 6:
                                return '[?? ??????????????] dddd [??] LT';
                        }
                    } else {
                        if (this.day() === 2) {
                            return '[????] dddd [??] LT';
                        } else {
                            return '[??] dddd [??] LT';
                        }
                    }
                },
                sameElse: 'L'
            },
            relativeTime: {
                future: '?????????? %s',
                past: '%s ??????????',
                s: '?????????????????? ????????????',
                m: relativeTimeWithPlural,
                mm: relativeTimeWithPlural,
                h: '??????',
                hh: relativeTimeWithPlural,
                d: '????????',
                dd: relativeTimeWithPlural,
                M: '??????????',
                MM: relativeTimeWithPlural,
                y: '??????',
                yy: relativeTimeWithPlural
            },

            meridiemParse: /????????|????????|??????|????????????/i,
            isPM: function (input) {
                return /^(??????|????????????)$/.test(input);
            },

            meridiem: function (hour, minute, isLower) {
                if (hour < 4) {
                    return '????????';
                } else if (hour < 12) {
                    return '????????';
                } else if (hour < 17) {
                    return '??????';
                } else {
                    return '????????????';
                }
            },

            ordinalParse: /\d{1,2}-(??|????|??)/,
            ordinal: function (number, period) {
                switch (period) {
                    case 'M':
                    case 'd':
                    case 'DDD':
                        return number + '-??';
                    case 'D':
                        return number + '-????';
                    case 'w':
                    case 'W':
                        return number + '-??';
                    default:
                        return number;
                }
            },

            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 7  // The week that contains Jan 1st is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : slovak (sk)
// author : Martin Minka : https://github.com/k2s
// based on work of petrbela : https://github.com/petrbela

    (function (factory) {
        factory(moment);
    }(function (moment) {
        var months = 'janu??r_febru??r_marec_apr??l_m??j_j??n_j??l_august_september_okt??ber_november_december'.split('_'),
                monthsShort = 'jan_feb_mar_apr_m??j_j??n_j??l_aug_sep_okt_nov_dec'.split('_');

        function plural(n) {
            return (n > 1) && (n < 5);
        }

        function translate(number, withoutSuffix, key, isFuture) {
            var result = number + ' ';
            switch (key) {
                case 's':  // a few seconds / in a few seconds / a few seconds ago
                    return (withoutSuffix || isFuture) ? 'p??r sek??nd' : 'p??r sekundami';
                case 'm':  // a minute / in a minute / a minute ago
                    return withoutSuffix ? 'min??ta' : (isFuture ? 'min??tu' : 'min??tou');
                case 'mm': // 9 minutes / in 9 minutes / 9 minutes ago
                    if (withoutSuffix || isFuture) {
                        return result + (plural(number) ? 'min??ty' : 'min??t');
                    } else {
                        return result + 'min??tami';
                    }
                    break;
                case 'h':  // an hour / in an hour / an hour ago
                    return withoutSuffix ? 'hodina' : (isFuture ? 'hodinu' : 'hodinou');
                case 'hh': // 9 hours / in 9 hours / 9 hours ago
                    if (withoutSuffix || isFuture) {
                        return result + (plural(number) ? 'hodiny' : 'hod??n');
                    } else {
                        return result + 'hodinami';
                    }
                    break;
                case 'd':  // a day / in a day / a day ago
                    return (withoutSuffix || isFuture) ? 'de??' : 'd??om';
                case 'dd': // 9 days / in 9 days / 9 days ago
                    if (withoutSuffix || isFuture) {
                        return result + (plural(number) ? 'dni' : 'dn??');
                    } else {
                        return result + 'd??ami';
                    }
                    break;
                case 'M':  // a month / in a month / a month ago
                    return (withoutSuffix || isFuture) ? 'mesiac' : 'mesiacom';
                case 'MM': // 9 months / in 9 months / 9 months ago
                    if (withoutSuffix || isFuture) {
                        return result + (plural(number) ? 'mesiace' : 'mesiacov');
                    } else {
                        return result + 'mesiacmi';
                    }
                    break;
                case 'y':  // a year / in a year / a year ago
                    return (withoutSuffix || isFuture) ? 'rok' : 'rokom';
                case 'yy': // 9 years / in 9 years / 9 years ago
                    if (withoutSuffix || isFuture) {
                        return result + (plural(number) ? 'roky' : 'rokov');
                    } else {
                        return result + 'rokmi';
                    }
                    break;
            }
        }

        return moment.defineLocale('sk', {
            months: months,
            monthsShort: monthsShort,
            monthsParse: (function (months, monthsShort) {
                var i, _monthsParse = [];
                for (i = 0; i < 12; i++) {
                    // use custom parser to solve problem with July (??ervenec)
                    _monthsParse[i] = new RegExp('^' + months[i] + '$|^' + monthsShort[i] + '$', 'i');
                }
                return _monthsParse;
            }(months, monthsShort)),
            weekdays: 'nede??a_pondelok_utorok_streda_??tvrtok_piatok_sobota'.split('_'),
            weekdaysShort: 'ne_po_ut_st_??t_pi_so'.split('_'),
            weekdaysMin: 'ne_po_ut_st_??t_pi_so'.split('_'),
            longDateFormat: {
                LT: 'H:mm',
                LTS: 'LT:ss',
                L: 'DD.MM.YYYY',
                LL: 'D. MMMM YYYY',
                LLL: 'D. MMMM YYYY LT',
                LLLL: 'dddd D. MMMM YYYY LT'
            },
            calendar: {
                sameDay: '[dnes o] LT',
                nextDay: '[zajtra o] LT',
                nextWeek: function () {
                    switch (this.day()) {
                        case 0:
                            return '[v nede??u o] LT';
                        case 1:
                        case 2:
                            return '[v] dddd [o] LT';
                        case 3:
                            return '[v stredu o] LT';
                        case 4:
                            return '[vo ??tvrtok o] LT';
                        case 5:
                            return '[v piatok o] LT';
                        case 6:
                            return '[v sobotu o] LT';
                    }
                },
                lastDay: '[v??era o] LT',
                lastWeek: function () {
                    switch (this.day()) {
                        case 0:
                            return '[minul?? nede??u o] LT';
                        case 1:
                        case 2:
                            return '[minul??] dddd [o] LT';
                        case 3:
                            return '[minul?? stredu o] LT';
                        case 4:
                        case 5:
                            return '[minul??] dddd [o] LT';
                        case 6:
                            return '[minul?? sobotu o] LT';
                    }
                },
                sameElse: 'L'
            },
            relativeTime: {
                future: 'za %s',
                past: 'pred %s',
                s: translate,
                m: translate,
                mm: translate,
                h: translate,
                hh: translate,
                d: translate,
                dd: translate,
                M: translate,
                MM: translate,
                y: translate,
                yy: translate
            },
            ordinalParse: /\d{1,2}\./,
            ordinal: '%d.',
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 4  // The week that contains Jan 4th is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : slovenian (sl)
// author : Robert Sedov??ek : https://github.com/sedovsek

    (function (factory) {
        factory(moment);
    }(function (moment) {
        function translate(number, withoutSuffix, key) {
            var result = number + ' ';
            switch (key) {
                case 'm':
                    return withoutSuffix ? 'ena minuta' : 'eno minuto';
                case 'mm':
                    if (number === 1) {
                        result += 'minuta';
                    } else if (number === 2) {
                        result += 'minuti';
                    } else if (number === 3 || number === 4) {
                        result += 'minute';
                    } else {
                        result += 'minut';
                    }
                    return result;
                case 'h':
                    return withoutSuffix ? 'ena ura' : 'eno uro';
                case 'hh':
                    if (number === 1) {
                        result += 'ura';
                    } else if (number === 2) {
                        result += 'uri';
                    } else if (number === 3 || number === 4) {
                        result += 'ure';
                    } else {
                        result += 'ur';
                    }
                    return result;
                case 'dd':
                    if (number === 1) {
                        result += 'dan';
                    } else {
                        result += 'dni';
                    }
                    return result;
                case 'MM':
                    if (number === 1) {
                        result += 'mesec';
                    } else if (number === 2) {
                        result += 'meseca';
                    } else if (number === 3 || number === 4) {
                        result += 'mesece';
                    } else {
                        result += 'mesecev';
                    }
                    return result;
                case 'yy':
                    if (number === 1) {
                        result += 'leto';
                    } else if (number === 2) {
                        result += 'leti';
                    } else if (number === 3 || number === 4) {
                        result += 'leta';
                    } else {
                        result += 'let';
                    }
                    return result;
            }
        }

        return moment.defineLocale('sl', {
            months: 'januar_februar_marec_april_maj_junij_julij_avgust_september_oktober_november_december'.split('_'),
            monthsShort: 'jan._feb._mar._apr._maj._jun._jul._avg._sep._okt._nov._dec.'.split('_'),
            weekdays: 'nedelja_ponedeljek_torek_sreda_??etrtek_petek_sobota'.split('_'),
            weekdaysShort: 'ned._pon._tor._sre._??et._pet._sob.'.split('_'),
            weekdaysMin: 'ne_po_to_sr_??e_pe_so'.split('_'),
            longDateFormat: {
                LT: 'H:mm',
                LTS: 'LT:ss',
                L: 'DD. MM. YYYY',
                LL: 'D. MMMM YYYY',
                LLL: 'D. MMMM YYYY LT',
                LLLL: 'dddd, D. MMMM YYYY LT'
            },
            calendar: {
                sameDay: '[danes ob] LT',
                nextDay: '[jutri ob] LT',

                nextWeek: function () {
                    switch (this.day()) {
                        case 0:
                            return '[v] [nedeljo] [ob] LT';
                        case 3:
                            return '[v] [sredo] [ob] LT';
                        case 6:
                            return '[v] [soboto] [ob] LT';
                        case 1:
                        case 2:
                        case 4:
                        case 5:
                            return '[v] dddd [ob] LT';
                    }
                },
                lastDay: '[v??eraj ob] LT',
                lastWeek: function () {
                    switch (this.day()) {
                        case 0:
                        case 3:
                        case 6:
                            return '[prej??nja] dddd [ob] LT';
                        case 1:
                        case 2:
                        case 4:
                        case 5:
                            return '[prej??nji] dddd [ob] LT';
                    }
                },
                sameElse: 'L'
            },
            relativeTime: {
                future: '??ez %s',
                past: '%s nazaj',
                s: 'nekaj sekund',
                m: translate,
                mm: translate,
                h: translate,
                hh: translate,
                d: 'en dan',
                dd: translate,
                M: 'en mesec',
                MM: translate,
                y: 'eno leto',
                yy: translate
            },
            ordinalParse: /\d{1,2}\./,
            ordinal: '%d.',
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 7  // The week that contains Jan 1st is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : Albanian (sq)
// author : Flak??rim Ismani : https://github.com/flakerimi
// author: Menelion Elens??le: https://github.com/Oire (tests)
// author : Oerd Cukalla : https://github.com/oerd (fixes)

    (function (factory) {
        factory(moment);
    }(function (moment) {
        return moment.defineLocale('sq', {
            months: 'Janar_Shkurt_Mars_Prill_Maj_Qershor_Korrik_Gusht_Shtator_Tetor_N??ntor_Dhjetor'.split('_'),
            monthsShort: 'Jan_Shk_Mar_Pri_Maj_Qer_Kor_Gus_Sht_Tet_N??n_Dhj'.split('_'),
            weekdays: 'E Diel_E H??n??_E Mart??_E M??rkur??_E Enjte_E Premte_E Shtun??'.split('_'),
            weekdaysShort: 'Die_H??n_Mar_M??r_Enj_Pre_Sht'.split('_'),
            weekdaysMin: 'D_H_Ma_M??_E_P_Sh'.split('_'),
            meridiemParse: /PD|MD/,
            isPM: function (input) {
                return input.charAt(0) === 'M';
            },
            meridiem: function (hours, minutes, isLower) {
                return hours < 12 ? 'PD' : 'MD';
            },
            longDateFormat: {
                LT: 'HH:mm',
                LTS: 'LT:ss',
                L: 'DD/MM/YYYY',
                LL: 'D MMMM YYYY',
                LLL: 'D MMMM YYYY LT',
                LLLL: 'dddd, D MMMM YYYY LT'
            },
            calendar: {
                sameDay: '[Sot n??] LT',
                nextDay: '[Nes??r n??] LT',
                nextWeek: 'dddd [n??] LT',
                lastDay: '[Dje n??] LT',
                lastWeek: 'dddd [e kaluar n??] LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: 'n?? %s',
                past: '%s m?? par??',
                s: 'disa sekonda',
                m: 'nj?? minut??',
                mm: '%d minuta',
                h: 'nj?? or??',
                hh: '%d or??',
                d: 'nj?? dit??',
                dd: '%d dit??',
                M: 'nj?? muaj',
                MM: '%d muaj',
                y: 'nj?? vit',
                yy: '%d vite'
            },
            ordinalParse: /\d{1,2}\./,
            ordinal: '%d.',
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 4  // The week that contains Jan 4th is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : Serbian-cyrillic (sr-cyrl)
// author : Milan Jana??kovi??<milanjanackovic@gmail.com> : https://github.com/milan-j

    (function (factory) {
        factory(moment);
    }(function (moment) {
        var translator = {
            words: {//Different grammatical cases
                m: ['?????????? ??????????', '?????????? ????????????'],
                mm: ['??????????', '????????????', '????????????'],
                h: ['?????????? ??????', '???????????? ????????'],
                hh: ['??????', '????????', '????????'],
                dd: ['??????', '????????', '????????'],
                MM: ['??????????', '????????????', '????????????'],
                yy: ['????????????', '????????????', '????????????']
            },
            correctGrammaticalCase: function (number, wordKey) {
                return number === 1 ? wordKey[0] : (number >= 2 && number <= 4 ? wordKey[1] : wordKey[2]);
            },
            translate: function (number, withoutSuffix, key) {
                var wordKey = translator.words[key];
                if (key.length === 1) {
                    return withoutSuffix ? wordKey[0] : wordKey[1];
                } else {
                    return number + ' ' + translator.correctGrammaticalCase(number, wordKey);
                }
            }
        };

        return moment.defineLocale('sr-cyrl', {
            months: ['????????????', '??????????????', '????????', '??????????', '??????', '??????', '??????', '????????????', '??????????????????', '??????????????', '????????????????', '????????????????'],
            monthsShort: ['??????.', '??????.', '??????.', '??????.', '??????', '??????', '??????', '??????.', '??????.', '??????.', '??????.', '??????.'],
            weekdays: ['????????????', '??????????????????', '????????????', '??????????', '????????????????', '??????????', '????????????'],
            weekdaysShort: ['??????.', '??????.', '??????.', '??????.', '??????.', '??????.', '??????.'],
            weekdaysMin: ['????', '????', '????', '????', '????', '????', '????'],
            longDateFormat: {
                LT: 'H:mm',
                LTS: 'LT:ss',
                L: 'DD. MM. YYYY',
                LL: 'D. MMMM YYYY',
                LLL: 'D. MMMM YYYY LT',
                LLLL: 'dddd, D. MMMM YYYY LT'
            },
            calendar: {
                sameDay: '[?????????? ??] LT',
                nextDay: '[?????????? ??] LT',

                nextWeek: function () {
                    switch (this.day()) {
                        case 0:
                            return '[??] [????????????] [??] LT';
                        case 3:
                            return '[??] [??????????] [??] LT';
                        case 6:
                            return '[??] [????????????] [??] LT';
                        case 1:
                        case 2:
                        case 4:
                        case 5:
                            return '[??] dddd [??] LT';
                    }
                },
                lastDay: '[???????? ??] LT',
                lastWeek: function () {
                    var lastWeekDays = [
                        '[????????????] [????????????] [??] LT',
                        '[??????????????] [??????????????????] [??] LT',
                        '[??????????????] [????????????] [??] LT',
                        '[????????????] [??????????] [??] LT',
                        '[??????????????] [????????????????] [??] LT',
                        '[??????????????] [??????????] [??] LT',
                        '[????????????] [????????????] [??] LT'
                    ];
                    return lastWeekDays[this.day()];
                },
                sameElse: 'L'
            },
            relativeTime: {
                future: '???? %s',
                past: '?????? %s',
                s: '???????????????? ??????????????',
                m: translator.translate,
                mm: translator.translate,
                h: translator.translate,
                hh: translator.translate,
                d: '??????',
                dd: translator.translate,
                M: '??????????',
                MM: translator.translate,
                y: '????????????',
                yy: translator.translate
            },
            ordinalParse: /\d{1,2}\./,
            ordinal: '%d.',
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 7  // The week that contains Jan 1st is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : Serbian-latin (sr)
// author : Milan Jana??kovi??<milanjanackovic@gmail.com> : https://github.com/milan-j

    (function (factory) {
        factory(moment);
    }(function (moment) {
        var translator = {
            words: {//Different grammatical cases
                m: ['jedan minut', 'jedne minute'],
                mm: ['minut', 'minute', 'minuta'],
                h: ['jedan sat', 'jednog sata'],
                hh: ['sat', 'sata', 'sati'],
                dd: ['dan', 'dana', 'dana'],
                MM: ['mesec', 'meseca', 'meseci'],
                yy: ['godina', 'godine', 'godina']
            },
            correctGrammaticalCase: function (number, wordKey) {
                return number === 1 ? wordKey[0] : (number >= 2 && number <= 4 ? wordKey[1] : wordKey[2]);
            },
            translate: function (number, withoutSuffix, key) {
                var wordKey = translator.words[key];
                if (key.length === 1) {
                    return withoutSuffix ? wordKey[0] : wordKey[1];
                } else {
                    return number + ' ' + translator.correctGrammaticalCase(number, wordKey);
                }
            }
        };

        return moment.defineLocale('sr', {
            months: ['januar', 'februar', 'mart', 'april', 'maj', 'jun', 'jul', 'avgust', 'septembar', 'oktobar', 'novembar', 'decembar'],
            monthsShort: ['jan.', 'feb.', 'mar.', 'apr.', 'maj', 'jun', 'jul', 'avg.', 'sep.', 'okt.', 'nov.', 'dec.'],
            weekdays: ['nedelja', 'ponedeljak', 'utorak', 'sreda', '??etvrtak', 'petak', 'subota'],
            weekdaysShort: ['ned.', 'pon.', 'uto.', 'sre.', '??et.', 'pet.', 'sub.'],
            weekdaysMin: ['ne', 'po', 'ut', 'sr', '??e', 'pe', 'su'],
            longDateFormat: {
                LT: 'H:mm',
                LTS: 'LT:ss',
                L: 'DD. MM. YYYY',
                LL: 'D. MMMM YYYY',
                LLL: 'D. MMMM YYYY LT',
                LLLL: 'dddd, D. MMMM YYYY LT'
            },
            calendar: {
                sameDay: '[danas u] LT',
                nextDay: '[sutra u] LT',

                nextWeek: function () {
                    switch (this.day()) {
                        case 0:
                            return '[u] [nedelju] [u] LT';
                        case 3:
                            return '[u] [sredu] [u] LT';
                        case 6:
                            return '[u] [subotu] [u] LT';
                        case 1:
                        case 2:
                        case 4:
                        case 5:
                            return '[u] dddd [u] LT';
                    }
                },
                lastDay: '[ju??e u] LT',
                lastWeek: function () {
                    var lastWeekDays = [
                        '[pro??le] [nedelje] [u] LT',
                        '[pro??log] [ponedeljka] [u] LT',
                        '[pro??log] [utorka] [u] LT',
                        '[pro??le] [srede] [u] LT',
                        '[pro??log] [??etvrtka] [u] LT',
                        '[pro??log] [petka] [u] LT',
                        '[pro??le] [subote] [u] LT'
                    ];
                    return lastWeekDays[this.day()];
                },
                sameElse: 'L'
            },
            relativeTime: {
                future: 'za %s',
                past: 'pre %s',
                s: 'nekoliko sekundi',
                m: translator.translate,
                mm: translator.translate,
                h: translator.translate,
                hh: translator.translate,
                d: 'dan',
                dd: translator.translate,
                M: 'mesec',
                MM: translator.translate,
                y: 'godinu',
                yy: translator.translate
            },
            ordinalParse: /\d{1,2}\./,
            ordinal: '%d.',
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 7  // The week that contains Jan 1st is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : swedish (sv)
// author : Jens Alm : https://github.com/ulmus

    (function (factory) {
        factory(moment);
    }(function (moment) {
        return moment.defineLocale('sv', {
            months: 'januari_februari_mars_april_maj_juni_juli_augusti_september_oktober_november_december'.split('_'),
            monthsShort: 'jan_feb_mar_apr_maj_jun_jul_aug_sep_okt_nov_dec'.split('_'),
            weekdays: 's??ndag_m??ndag_tisdag_onsdag_torsdag_fredag_l??rdag'.split('_'),
            weekdaysShort: 's??n_m??n_tis_ons_tor_fre_l??r'.split('_'),
            weekdaysMin: 's??_m??_ti_on_to_fr_l??'.split('_'),
            longDateFormat: {
                LT: 'HH:mm',
                LTS: 'LT:ss',
                L: 'YYYY-MM-DD',
                LL: 'D MMMM YYYY',
                LLL: 'D MMMM YYYY LT',
                LLLL: 'dddd D MMMM YYYY LT'
            },
            calendar: {
                sameDay: '[Idag] LT',
                nextDay: '[Imorgon] LT',
                lastDay: '[Ig??r] LT',
                nextWeek: 'dddd LT',
                lastWeek: '[F??rra] dddd[en] LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: 'om %s',
                past: 'f??r %s sedan',
                s: 'n??gra sekunder',
                m: 'en minut',
                mm: '%d minuter',
                h: 'en timme',
                hh: '%d timmar',
                d: 'en dag',
                dd: '%d dagar',
                M: 'en m??nad',
                MM: '%d m??nader',
                y: 'ett ??r',
                yy: '%d ??r'
            },
            ordinalParse: /\d{1,2}(e|a)/,
            ordinal: function (number) {
                var b = number % 10,
                        output = (~~(number % 100 / 10) === 1) ? 'e' :
                        (b === 1) ? 'a' :
                        (b === 2) ? 'a' :
                        (b === 3) ? 'e' : 'e';
                return number + output;
            },
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 4  // The week that contains Jan 4th is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : tamil (ta)
// author : Arjunkumar Krishnamoorthy : https://github.com/tk120404

    (function (factory) {
        factory(moment);
    }(function (moment) {
        /*var symbolMap = {
         '1': '???',
         '2': '???',
         '3': '???',
         '4': '???',
         '5': '???',
         '6': '???',
         '7': '???',
         '8': '???',
         '9': '???',
         '0': '???'
         },
         numberMap = {
         '???': '1',
         '???': '2',
         '???': '3',
         '???': '4',
         '???': '5',
         '???': '6',
         '???': '7',
         '???': '8',
         '???': '9',
         '???': '0'
         }; */

        return moment.defineLocale('ta', {
            months: '???????????????_????????????????????????_??????????????????_??????????????????_??????_????????????_????????????_??????????????????_?????????????????????????????????_???????????????????????????_?????????????????????_????????????????????????'.split('_'),
            monthsShort: '???????????????_????????????????????????_??????????????????_??????????????????_??????_????????????_????????????_??????????????????_?????????????????????????????????_???????????????????????????_?????????????????????_????????????????????????'.split('_'),
            weekdays: '?????????????????????????????????????????????_????????????????????????????????????_???????????????????????????????????????_??????????????????????????????_????????????????????????????????????_???????????????????????????????????????_??????????????????????????????'.split('_'),
            weekdaysShort: '??????????????????_?????????????????????_????????????????????????_???????????????_?????????????????????_??????????????????_?????????'.split('_'),
            weekdaysMin: '??????_??????_??????_??????_??????_??????_???'.split('_'),
            longDateFormat: {
                LT: 'HH:mm',
                LTS: 'LT:ss',
                L: 'DD/MM/YYYY',
                LL: 'D MMMM YYYY',
                LLL: 'D MMMM YYYY, LT',
                LLLL: 'dddd, D MMMM YYYY, LT'
            },
            calendar: {
                sameDay: '[???????????????] LT',
                nextDay: '[????????????] LT',
                nextWeek: 'dddd, LT',
                lastDay: '[??????????????????] LT',
                lastWeek: '[??????????????? ???????????????] dddd, LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: '%s ?????????',
                past: '%s ????????????',
                s: '????????? ????????? ???????????????????????????',
                m: '????????? ?????????????????????',
                mm: '%d ??????????????????????????????',
                h: '????????? ????????? ???????????????',
                hh: '%d ????????? ???????????????',
                d: '????????? ????????????',
                dd: '%d ?????????????????????',
                M: '????????? ???????????????',
                MM: '%d ????????????????????????',
                y: '????????? ??????????????????',
                yy: '%d ????????????????????????'
            },
            /*        preparse: function (string) {
             return string.replace(/[??????????????????????????????]/g, function (match) {
             return numberMap[match];
             });
             },
             postformat: function (string) {
             return string.replace(/\d/g, function (match) {
             return symbolMap[match];
             });
             },*/
            ordinalParse: /\d{1,2}?????????/,
            ordinal: function (number) {
                return number + '?????????';
            },

            // refer http://ta.wikipedia.org/s/1er1
            meridiemParse: /???????????????|???????????????|????????????|?????????????????????|?????????????????????|????????????/,
            meridiem: function (hour, minute, isLower) {
                if (hour < 2) {
                    return ' ???????????????';
                } else if (hour < 6) {
                    return ' ???????????????';  // ???????????????
                } else if (hour < 10) {
                    return ' ????????????'; // ????????????
                } else if (hour < 14) {
                    return ' ?????????????????????'; // ?????????????????????
                } else if (hour < 18) {
                    return ' ?????????????????????'; // ?????????????????????
                } else if (hour < 22) {
                    return ' ????????????'; // ????????????
                } else {
                    return ' ???????????????';
                }
            },
            meridiemHour: function (hour, meridiem) {
                if (hour === 12) {
                    hour = 0;
                }
                if (meridiem === '???????????????') {
                    return hour < 2 ? hour : hour + 12;
                } else if (meridiem === '???????????????' || meridiem === '????????????') {
                    return hour;
                } else if (meridiem === '?????????????????????') {
                    return hour >= 10 ? hour : hour + 12;
                } else {
                    return hour + 12;
                }
            },
            week: {
                dow: 0, // Sunday is the first day of the week.
                doy: 6  // The week that contains Jan 1st is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : thai (th)
// author : Kridsada Thanabulpong : https://github.com/sirn

    (function (factory) {
        factory(moment);
    }(function (moment) {
        return moment.defineLocale('th', {
            months: '??????????????????_??????????????????????????????_??????????????????_??????????????????_?????????????????????_????????????????????????_?????????????????????_?????????????????????_?????????????????????_??????????????????_???????????????????????????_?????????????????????'.split('_'),
            monthsShort: '????????????_???????????????_????????????_????????????_???????????????_??????????????????_???????????????_???????????????_???????????????_????????????_?????????????????????_???????????????'.split('_'),
            weekdays: '?????????????????????_??????????????????_??????????????????_?????????_????????????????????????_???????????????_???????????????'.split('_'),
            weekdaysShort: '?????????????????????_??????????????????_??????????????????_?????????_???????????????_???????????????_???????????????'.split('_'), // yes, three characters difference
            weekdaysMin: '??????._???._???._???._??????._???._???.'.split('_'),
            longDateFormat: {
                LT: 'H ?????????????????? m ????????????',
                LTS: 'LT s ??????????????????',
                L: 'YYYY/MM/DD',
                LL: 'D MMMM YYYY',
                LLL: 'D MMMM YYYY ???????????? LT',
                LLLL: '?????????dddd????????? D MMMM YYYY ???????????? LT'
            },
            meridiemParse: /??????????????????????????????|??????????????????????????????/,
            isPM: function (input) {
                return input === '??????????????????????????????';
            },
            meridiem: function (hour, minute, isLower) {
                if (hour < 12) {
                    return '??????????????????????????????';
                } else {
                    return '??????????????????????????????';
                }
            },
            calendar: {
                sameDay: '[?????????????????? ????????????] LT',
                nextDay: '[???????????????????????? ????????????] LT',
                nextWeek: 'dddd[???????????? ????????????] LT',
                lastDay: '[????????????????????????????????? ????????????] LT',
                lastWeek: '[?????????]dddd[????????????????????? ????????????] LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: '????????? %s',
                past: '%s?????????????????????',
                s: '????????????????????????????????????',
                m: '1 ????????????',
                mm: '%d ????????????',
                h: '1 ?????????????????????',
                hh: '%d ?????????????????????',
                d: '1 ?????????',
                dd: '%d ?????????',
                M: '1 ???????????????',
                MM: '%d ???????????????',
                y: '1 ??????',
                yy: '%d ??????'
            }
        });
    }));
// moment.js locale configuration
// locale : Tagalog/Filipino (tl-ph)
// author : Dan Hagman

    (function (factory) {
        factory(moment);
    }(function (moment) {
        return moment.defineLocale('tl-ph', {
            months: 'Enero_Pebrero_Marso_Abril_Mayo_Hunyo_Hulyo_Agosto_Setyembre_Oktubre_Nobyembre_Disyembre'.split('_'),
            monthsShort: 'Ene_Peb_Mar_Abr_May_Hun_Hul_Ago_Set_Okt_Nob_Dis'.split('_'),
            weekdays: 'Linggo_Lunes_Martes_Miyerkules_Huwebes_Biyernes_Sabado'.split('_'),
            weekdaysShort: 'Lin_Lun_Mar_Miy_Huw_Biy_Sab'.split('_'),
            weekdaysMin: 'Li_Lu_Ma_Mi_Hu_Bi_Sab'.split('_'),
            longDateFormat: {
                LT: 'HH:mm',
                LTS: 'LT:ss',
                L: 'MM/D/YYYY',
                LL: 'MMMM D, YYYY',
                LLL: 'MMMM D, YYYY LT',
                LLLL: 'dddd, MMMM DD, YYYY LT'
            },
            calendar: {
                sameDay: '[Ngayon sa] LT',
                nextDay: '[Bukas sa] LT',
                nextWeek: 'dddd [sa] LT',
                lastDay: '[Kahapon sa] LT',
                lastWeek: 'dddd [huling linggo] LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: 'sa loob ng %s',
                past: '%s ang nakalipas',
                s: 'ilang segundo',
                m: 'isang minuto',
                mm: '%d minuto',
                h: 'isang oras',
                hh: '%d oras',
                d: 'isang araw',
                dd: '%d araw',
                M: 'isang buwan',
                MM: '%d buwan',
                y: 'isang taon',
                yy: '%d taon'
            },
            ordinalParse: /\d{1,2}/,
            ordinal: function (number) {
                return number;
            },
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 4  // The week that contains Jan 4th is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : turkish (tr)
// authors : Erhan Gundogan : https://github.com/erhangundogan,
//           Burak Yi??it Kaya: https://github.com/BYK

    (function (factory) {
        factory(moment);
    }(function (moment) {
        var suffixes = {
            1: '\'inci',
            5: '\'inci',
            8: '\'inci',
            70: '\'inci',
            80: '\'inci',

            2: '\'nci',
            7: '\'nci',
            20: '\'nci',
            50: '\'nci',

            3: '\'??nc??',
            4: '\'??nc??',
            100: '\'??nc??',

            6: '\'nc??',

            9: '\'uncu',
            10: '\'uncu',
            30: '\'uncu',

            60: '\'??nc??',
            90: '\'??nc??'
        };

        return moment.defineLocale('tr', {
            months: 'Ocak_??ubat_Mart_Nisan_May??s_Haziran_Temmuz_A??ustos_Eyl??l_Ekim_Kas??m_Aral??k'.split('_'),
            monthsShort: 'Oca_??ub_Mar_Nis_May_Haz_Tem_A??u_Eyl_Eki_Kas_Ara'.split('_'),
            weekdays: 'Pazar_Pazartesi_Sal??_??ar??amba_Per??embe_Cuma_Cumartesi'.split('_'),
            weekdaysShort: 'Paz_Pts_Sal_??ar_Per_Cum_Cts'.split('_'),
            weekdaysMin: 'Pz_Pt_Sa_??a_Pe_Cu_Ct'.split('_'),
            longDateFormat: {
                LT: 'HH:mm',
                LTS: 'LT:ss',
                L: 'DD.MM.YYYY',
                LL: 'D MMMM YYYY',
                LLL: 'D MMMM YYYY LT',
                LLLL: 'dddd, D MMMM YYYY LT'
            },
            calendar: {
                sameDay: '[bug??n saat] LT',
                nextDay: '[yar??n saat] LT',
                nextWeek: '[haftaya] dddd [saat] LT',
                lastDay: '[d??n] LT',
                lastWeek: '[ge??en hafta] dddd [saat] LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: '%s sonra',
                past: '%s ??nce',
                s: 'birka?? saniye',
                m: 'bir dakika',
                mm: '%d dakika',
                h: 'bir saat',
                hh: '%d saat',
                d: 'bir g??n',
                dd: '%d g??n',
                M: 'bir ay',
                MM: '%d ay',
                y: 'bir y??l',
                yy: '%d y??l'
            },
            ordinalParse: /\d{1,2}'(inci|nci|??nc??|nc??|uncu|??nc??)/,
            ordinal: function (number) {
                if (number === 0) {  // special case for zero
                    return number + '\'??nc??';
                }
                var a = number % 10,
                        b = number % 100 - a,
                        c = number >= 100 ? 100 : null;

                return number + (suffixes[a] || suffixes[b] || suffixes[c]);
            },
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 7  // The week that contains Jan 1st is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : Morocco Central Atlas Tamazi??t in Latin (tzm-latn)
// author : Abdel Said : https://github.com/abdelsaid

    (function (factory) {
        factory(moment);
    }(function (moment) {
        return moment.defineLocale('tzm-latn', {
            months: 'innayr_br??ayr??_mar??s??_ibrir_mayyw_ywnyw_ywlywz_??w??t_??wtanbir_kt??wbr??_nwwanbir_dwjnbir'.split('_'),
            monthsShort: 'innayr_br??ayr??_mar??s??_ibrir_mayyw_ywnyw_ywlywz_??w??t_??wtanbir_kt??wbr??_nwwanbir_dwjnbir'.split('_'),
            weekdays: 'asamas_aynas_asinas_akras_akwas_asimwas_asi???yas'.split('_'),
            weekdaysShort: 'asamas_aynas_asinas_akras_akwas_asimwas_asi???yas'.split('_'),
            weekdaysMin: 'asamas_aynas_asinas_akras_akwas_asimwas_asi???yas'.split('_'),
            longDateFormat: {
                LT: 'HH:mm',
                LTS: 'LT:ss',
                L: 'DD/MM/YYYY',
                LL: 'D MMMM YYYY',
                LLL: 'D MMMM YYYY LT',
                LLLL: 'dddd D MMMM YYYY LT'
            },
            calendar: {
                sameDay: '[asdkh g] LT',
                nextDay: '[aska g] LT',
                nextWeek: 'dddd [g] LT',
                lastDay: '[assant g] LT',
                lastWeek: 'dddd [g] LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: 'dadkh s yan %s',
                past: 'yan %s',
                s: 'imik',
                m: 'minu???',
                mm: '%d minu???',
                h: 'sa??a',
                hh: '%d tassa??in',
                d: 'ass',
                dd: '%d ossan',
                M: 'ayowr',
                MM: '%d iyyirn',
                y: 'asgas',
                yy: '%d isgasn'
            },
            week: {
                dow: 6, // Saturday is the first day of the week.
                doy: 12  // The week that contains Jan 1st is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : Morocco Central Atlas Tamazi??t (tzm)
// author : Abdel Said : https://github.com/abdelsaid

    (function (factory) {
        factory(moment);
    }(function (moment) {
        return moment.defineLocale('tzm', {
            months: '??????????????????_???????????????_????????????_???????????????_???????????????_???????????????_??????????????????_????????????_????????????????????????_???????????????_????????????????????????_?????????????????????'.split('_'),
            monthsShort: '??????????????????_???????????????_????????????_???????????????_???????????????_???????????????_??????????????????_????????????_????????????????????????_???????????????_????????????????????????_?????????????????????'.split('_'),
            weekdays: '??????????????????_???????????????_??????????????????_???????????????_???????????????_?????????????????????_?????????????????????'.split('_'),
            weekdaysShort: '??????????????????_???????????????_??????????????????_???????????????_???????????????_?????????????????????_?????????????????????'.split('_'),
            weekdaysMin: '??????????????????_???????????????_??????????????????_???????????????_???????????????_?????????????????????_?????????????????????'.split('_'),
            longDateFormat: {
                LT: 'HH:mm',
                LTS: 'LT:ss',
                L: 'DD/MM/YYYY',
                LL: 'D MMMM YYYY',
                LLL: 'D MMMM YYYY LT',
                LLLL: 'dddd D MMMM YYYY LT'
            },
            calendar: {
                sameDay: '[???????????? ???] LT',
                nextDay: '[???????????? ???] LT',
                nextWeek: 'dddd [???] LT',
                lastDay: '[??????????????? ???] LT',
                lastWeek: 'dddd [???] LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: '???????????? ??? ????????? %s',
                past: '????????? %s',
                s: '????????????',
                m: '???????????????',
                mm: '%d ???????????????',
                h: '????????????',
                hh: '%d ????????????????????????',
                d: '?????????',
                dd: '%d o????????????',
                M: '??????o??????',
                MM: '%d ??????????????????',
                y: '???????????????',
                yy: '%d ??????????????????'
            },
            week: {
                dow: 6, // Saturday is the first day of the week.
                doy: 12  // The week that contains Jan 1st is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : ukrainian (uk)
// author : zemlanin : https://github.com/zemlanin
// Author : Menelion Elens??le : https://github.com/Oire

    (function (factory) {
        factory(moment);
    }(function (moment) {
        function plural(word, num) {
            var forms = word.split('_');
            return num % 10 === 1 && num % 100 !== 11 ? forms[0] : (num % 10 >= 2 && num % 10 <= 4 && (num % 100 < 10 || num % 100 >= 20) ? forms[1] : forms[2]);
        }

        function relativeTimeWithPlural(number, withoutSuffix, key) {
            var format = {
                'mm': '??????????????_??????????????_????????????',
                'hh': '????????????_????????????_??????????',
                'dd': '????????_??????_????????',
                'MM': '????????????_????????????_??????????????',
                'yy': '??????_????????_??????????'
            };
            if (key === 'm') {
                return withoutSuffix ? '??????????????' : '??????????????';
            } else if (key === 'h') {
                return withoutSuffix ? '????????????' : '????????????';
            } else {
                return number + ' ' + plural(format[key], +number);
            }
        }

        function monthsCaseReplace(m, format) {
            var months = {
                'nominative': '????????????_??????????_????????????????_??????????????_??????????????_??????????????_????????????_??????????????_????????????????_??????????????_????????????????_??????????????'.split('_'),
                'accusative': '??????????_????????????_??????????????_????????????_????????????_????????????_??????????_????????????_??????????????_????????????_??????????????????_????????????'.split('_')
            },
                    nounCase = (/D[oD]? *MMMM?/).test(format) ?
                    'accusative' :
                    'nominative';

            return months[nounCase][m.month()];
        }

        function weekdaysCaseReplace(m, format) {
            var weekdays = {
                'nominative': '????????????_??????????????????_????????????????_????????????_????????????_?????????????????_????????????'.split('_'),
                'accusative': '????????????_??????????????????_????????????????_????????????_????????????_?????????????????_????????????'.split('_'),
                'genitive': '????????????_??????????????????_????????????????_????????????_????????????????_?????????????????_????????????'.split('_')
            },
                    nounCase = (/(\[[????????]\]) ?dddd/).test(format) ?
                    'accusative' :
                    ((/\[?(?:??????????????|??????????????????)? ?\] ?dddd/).test(format) ?
                            'genitive' :
                            'nominative');

            return weekdays[nounCase][m.day()];
        }

        function processHoursFunction(str) {
            return function () {
                return str + '??' + (this.hours() === 11 ? '??' : '') + '] LT';
            };
        }

        return moment.defineLocale('uk', {
            months: monthsCaseReplace,
            monthsShort: '??????_??????_??????_????????_????????_????????_??????_????????_??????_????????_????????_????????'.split('_'),
            weekdays: weekdaysCaseReplace,
            weekdaysShort: '????_????_????_????_????_????_????'.split('_'),
            weekdaysMin: '????_????_????_????_????_????_????'.split('_'),
            longDateFormat: {
                LT: 'HH:mm',
                LTS: 'LT:ss',
                L: 'DD.MM.YYYY',
                LL: 'D MMMM YYYY ??.',
                LLL: 'D MMMM YYYY ??., LT',
                LLLL: 'dddd, D MMMM YYYY ??., LT'
            },
            calendar: {
                sameDay: processHoursFunction('[???????????????? '),
                nextDay: processHoursFunction('[???????????? '),
                lastDay: processHoursFunction('[?????????? '),
                nextWeek: processHoursFunction('[??] dddd ['),
                lastWeek: function () {
                    switch (this.day()) {
                        case 0:
                        case 3:
                        case 5:
                        case 6:
                            return processHoursFunction('[??????????????] dddd [').call(this);
                        case 1:
                        case 2:
                        case 4:
                            return processHoursFunction('[????????????????] dddd [').call(this);
                    }
                },
                sameElse: 'L'
            },
            relativeTime: {
                future: '???? %s',
                past: '%s ????????',
                s: '???????????????? ????????????',
                m: relativeTimeWithPlural,
                mm: relativeTimeWithPlural,
                h: '????????????',
                hh: relativeTimeWithPlural,
                d: '????????',
                dd: relativeTimeWithPlural,
                M: '????????????',
                MM: relativeTimeWithPlural,
                y: '??????',
                yy: relativeTimeWithPlural
            },

            // M. E.: those two are virtually unused but a user might want to implement them for his/her website for some reason

            meridiemParse: /????????|??????????|??????|????????????/,
            isPM: function (input) {
                return /^(??????|????????????)$/.test(input);
            },
            meridiem: function (hour, minute, isLower) {
                if (hour < 4) {
                    return '????????';
                } else if (hour < 12) {
                    return '??????????';
                } else if (hour < 17) {
                    return '??????';
                } else {
                    return '????????????';
                }
            },

            ordinalParse: /\d{1,2}-(??|????)/,
            ordinal: function (number, period) {
                switch (period) {
                    case 'M':
                    case 'd':
                    case 'DDD':
                    case 'w':
                    case 'W':
                        return number + '-??';
                    case 'D':
                        return number + '-????';
                    default:
                        return number;
                }
            },

            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 7  // The week that contains Jan 1st is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : uzbek (uz)
// author : Sardor Muminov : https://github.com/muminoff

    (function (factory) {
        factory(moment);
    }(function (moment) {
        return moment.defineLocale('uz', {
            months: '????????????_??????????????_????????_????????????_??????_????????_????????_????????????_????????????????_??????????????_????????????_??????????????'.split('_'),
            monthsShort: '??????_??????_??????_??????_??????_??????_??????_??????_??????_??????_??????_??????'.split('_'),
            weekdays: '??????????????_??????????????_??????????????_????????????????_????????????????_????????_??????????'.split('_'),
            weekdaysShort: '??????_??????_??????_??????_??????_??????_??????'.split('_'),
            weekdaysMin: '????_????_????_????_????_????_????'.split('_'),
            longDateFormat: {
                LT: 'HH:mm',
                LTS: 'LT:ss',
                L: 'DD/MM/YYYY',
                LL: 'D MMMM YYYY',
                LLL: 'D MMMM YYYY LT',
                LLLL: 'D MMMM YYYY, dddd LT'
            },
            calendar: {
                sameDay: '[?????????? ????????] LT [????]',
                nextDay: '[????????????] LT [????]',
                nextWeek: 'dddd [???????? ????????] LT [????]',
                lastDay: '[???????? ????????] LT [????]',
                lastWeek: '[??????????] dddd [???????? ????????] LT [????]',
                sameElse: 'L'
            },
            relativeTime: {
                future: '???????? %s ??????????',
                past: '?????? ???????? %s ??????????',
                s: '????????????',
                m: '?????? ????????????',
                mm: '%d ????????????',
                h: '?????? ????????',
                hh: '%d ????????',
                d: '?????? ??????',
                dd: '%d ??????',
                M: '?????? ????',
                MM: '%d ????',
                y: '?????? ??????',
                yy: '%d ??????'
            },
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 7  // The week that contains Jan 4th is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : vietnamese (vi)
// author : Bang Nguyen : https://github.com/bangnk

    (function (factory) {
        factory(moment);
    }(function (moment) {
        return moment.defineLocale('vi', {
            months: 'th??ng 1_th??ng 2_th??ng 3_th??ng 4_th??ng 5_th??ng 6_th??ng 7_th??ng 8_th??ng 9_th??ng 10_th??ng 11_th??ng 12'.split('_'),
            monthsShort: 'Th01_Th02_Th03_Th04_Th05_Th06_Th07_Th08_Th09_Th10_Th11_Th12'.split('_'),
            weekdays: 'ch??? nh???t_th??? hai_th??? ba_th??? t??_th??? n??m_th??? s??u_th??? b???y'.split('_'),
            weekdaysShort: 'CN_T2_T3_T4_T5_T6_T7'.split('_'),
            weekdaysMin: 'CN_T2_T3_T4_T5_T6_T7'.split('_'),
            longDateFormat: {
                LT: 'HH:mm',
                LTS: 'LT:ss',
                L: 'DD/MM/YYYY',
                LL: 'D MMMM [n??m] YYYY',
                LLL: 'D MMMM [n??m] YYYY LT',
                LLLL: 'dddd, D MMMM [n??m] YYYY LT',
                l: 'DD/M/YYYY',
                ll: 'D MMM YYYY',
                lll: 'D MMM YYYY LT',
                llll: 'ddd, D MMM YYYY LT'
            },
            calendar: {
                sameDay: '[H??m nay l??c] LT',
                nextDay: '[Ng??y mai l??c] LT',
                nextWeek: 'dddd [tu???n t???i l??c] LT',
                lastDay: '[H??m qua l??c] LT',
                lastWeek: 'dddd [tu???n r???i l??c] LT',
                sameElse: 'L'
            },
            relativeTime: {
                future: '%s t???i',
                past: '%s tr?????c',
                s: 'v??i gi??y',
                m: 'm???t ph??t',
                mm: '%d ph??t',
                h: 'm???t gi???',
                hh: '%d gi???',
                d: 'm???t ng??y',
                dd: '%d ng??y',
                M: 'm???t th??ng',
                MM: '%d th??ng',
                y: 'm???t n??m',
                yy: '%d n??m'
            },
            ordinalParse: /\d{1,2}/,
            ordinal: function (number) {
                return number;
            },
            week: {
                dow: 1, // Monday is the first day of the week.
                doy: 4  // The week that contains Jan 4th is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : chinese (zh-cn)
// author : suupic : https://github.com/suupic
// author : Zeno Zeng : https://github.com/zenozeng

    (function (factory) {
        factory(moment);
    }(function (moment) {
        return moment.defineLocale('zh-cn', {
            months: '??????_??????_??????_??????_??????_??????_??????_??????_??????_??????_?????????_?????????'.split('_'),
            monthsShort: '1???_2???_3???_4???_5???_6???_7???_8???_9???_10???_11???_12???'.split('_'),
            weekdays: '?????????_?????????_?????????_?????????_?????????_?????????_?????????'.split('_'),
            weekdaysShort: '??????_??????_??????_??????_??????_??????_??????'.split('_'),
            weekdaysMin: '???_???_???_???_???_???_???'.split('_'),
            longDateFormat: {
                LT: 'Ah???mm',
                LTS: 'Ah???m???s???',
                L: 'YYYY-MM-DD',
                LL: 'YYYY???MMMD???',
                LLL: 'YYYY???MMMD???LT',
                LLLL: 'YYYY???MMMD???ddddLT',
                l: 'YYYY-MM-DD',
                ll: 'YYYY???MMMD???',
                lll: 'YYYY???MMMD???LT',
                llll: 'YYYY???MMMD???ddddLT'
            },
            meridiemParse: /??????|??????|??????|??????|??????|??????/,
            meridiemHour: function (hour, meridiem) {
                if (hour === 12) {
                    hour = 0;
                }
                if (meridiem === '??????' || meridiem === '??????' ||
                        meridiem === '??????') {
                    return hour;
                } else if (meridiem === '??????' || meridiem === '??????') {
                    return hour + 12;
                } else {
                    // '??????'
                    return hour >= 11 ? hour : hour + 12;
                }
            },
            meridiem: function (hour, minute, isLower) {
                var hm = hour * 100 + minute;
                if (hm < 600) {
                    return '??????';
                } else if (hm < 900) {
                    return '??????';
                } else if (hm < 1130) {
                    return '??????';
                } else if (hm < 1230) {
                    return '??????';
                } else if (hm < 1800) {
                    return '??????';
                } else {
                    return '??????';
                }
            },
            calendar: {
                sameDay: function () {
                    return this.minutes() === 0 ? '[??????]Ah[??????]' : '[??????]LT';
                },
                nextDay: function () {
                    return this.minutes() === 0 ? '[??????]Ah[??????]' : '[??????]LT';
                },
                lastDay: function () {
                    return this.minutes() === 0 ? '[??????]Ah[??????]' : '[??????]LT';
                },
                nextWeek: function () {
                    var startOfWeek, prefix;
                    startOfWeek = moment().startOf('week');
                    prefix = this.unix() - startOfWeek.unix() >= 7 * 24 * 3600 ? '[???]' : '[???]';
                    return this.minutes() === 0 ? prefix + 'dddAh??????' : prefix + 'dddAh???mm';
                },
                lastWeek: function () {
                    var startOfWeek, prefix;
                    startOfWeek = moment().startOf('week');
                    prefix = this.unix() < startOfWeek.unix() ? '[???]' : '[???]';
                    return this.minutes() === 0 ? prefix + 'dddAh??????' : prefix + 'dddAh???mm';
                },
                sameElse: 'LL'
            },
            ordinalParse: /\d{1,2}(???|???|???)/,
            ordinal: function (number, period) {
                switch (period) {
                    case 'd':
                    case 'D':
                    case 'DDD':
                        return number + '???';
                    case 'M':
                        return number + '???';
                    case 'w':
                    case 'W':
                        return number + '???';
                    default:
                        return number;
                }
            },
            relativeTime: {
                future: '%s???',
                past: '%s???',
                s: '??????',
                m: '1??????',
                mm: '%d??????',
                h: '1??????',
                hh: '%d??????',
                d: '1???',
                dd: '%d???',
                M: '1??????',
                MM: '%d??????',
                y: '1???',
                yy: '%d???'
            },
            week: {
                // GB/T 7408-1994?????????????????????????????????????????????????????????????????????????ISO 8601:1988??????
                dow: 1, // Monday is the first day of the week.
                doy: 4  // The week that contains Jan 4th is the first week of the year.
            }
        });
    }));
// moment.js locale configuration
// locale : traditional chinese (zh-tw)
// author : Ben : https://github.com/ben-lin

    (function (factory) {
        factory(moment);
    }(function (moment) {
        return moment.defineLocale('zh-tw', {
            months: '??????_??????_??????_??????_??????_??????_??????_??????_??????_??????_?????????_?????????'.split('_'),
            monthsShort: '1???_2???_3???_4???_5???_6???_7???_8???_9???_10???_11???_12???'.split('_'),
            weekdays: '?????????_?????????_?????????_?????????_?????????_?????????_?????????'.split('_'),
            weekdaysShort: '??????_??????_??????_??????_??????_??????_??????'.split('_'),
            weekdaysMin: '???_???_???_???_???_???_???'.split('_'),
            longDateFormat: {
                LT: 'Ah???mm',
                LTS: 'Ah???m???s???',
                L: 'YYYY???MMMD???',
                LL: 'YYYY???MMMD???',
                LLL: 'YYYY???MMMD???LT',
                LLLL: 'YYYY???MMMD???ddddLT',
                l: 'YYYY???MMMD???',
                ll: 'YYYY???MMMD???',
                lll: 'YYYY???MMMD???LT',
                llll: 'YYYY???MMMD???ddddLT'
            },
            meridiemParse: /??????|??????|??????|??????|??????/,
            meridiemHour: function (hour, meridiem) {
                if (hour === 12) {
                    hour = 0;
                }
                if (meridiem === '??????' || meridiem === '??????') {
                    return hour;
                } else if (meridiem === '??????') {
                    return hour >= 11 ? hour : hour + 12;
                } else if (meridiem === '??????' || meridiem === '??????') {
                    return hour + 12;
                }
            },
            meridiem: function (hour, minute, isLower) {
                var hm = hour * 100 + minute;
                if (hm < 900) {
                    return '??????';
                } else if (hm < 1130) {
                    return '??????';
                } else if (hm < 1230) {
                    return '??????';
                } else if (hm < 1800) {
                    return '??????';
                } else {
                    return '??????';
                }
            },
            calendar: {
                sameDay: '[??????]LT',
                nextDay: '[??????]LT',
                nextWeek: '[???]ddddLT',
                lastDay: '[??????]LT',
                lastWeek: '[???]ddddLT',
                sameElse: 'L'
            },
            ordinalParse: /\d{1,2}(???|???|???)/,
            ordinal: function (number, period) {
                switch (period) {
                    case 'd' :
                    case 'D' :
                    case 'DDD' :
                        return number + '???';
                    case 'M' :
                        return number + '???';
                    case 'w' :
                    case 'W' :
                        return number + '???';
                    default :
                        return number;
                }
            },
            relativeTime: {
                future: '%s???',
                past: '%s???',
                s: '??????',
                m: '?????????',
                mm: '%d??????',
                h: '?????????',
                hh: '%d??????',
                d: '??????',
                dd: '%d???',
                M: '?????????',
                MM: '%d??????',
                y: '??????',
                yy: '%d???'
            }
        });
    }));

    moment.locale('en');


    /************************************
     Exposing Moment
     ************************************/

    function makeGlobal(shouldDeprecate) {
        /*global ender:false */
        if (typeof ender !== 'undefined') {
            return;
        }
        oldGlobalMoment = globalScope.moment;
        if (shouldDeprecate) {
            globalScope.moment = deprecate(
                    'Accessing Moment through the global scope is ' +
                    'deprecated, and will be removed in an upcoming ' +
                    'release.',
                    moment);
        } else {
            globalScope.moment = moment;
        }
    }

    // CommonJS module is defined
    if (hasModule) {
        module.exports = moment;
    } else if (typeof define === 'function' && define.amd) {
        define(function (require, exports, module) {
            if (module.config && module.config() && module.config().noGlobal === true) {
                // release the global variable
                globalScope.moment = oldGlobalMoment;
            }

            return moment;
        });
        makeGlobal(true);
    } else {
        makeGlobal();
    }
}).call(this);
// source --> https://vizulab.com.au/wp-content/themes/quark-child/js/custom.js?ver=5.9 
jQuery( document ).ready( function( $ ) {
	
	/*Scroll transition to anchor*/
	$("a.slow-scroll").on('click',function(e) {
		var url = e.target.href;
		var hash = url.substring(url.indexOf("#")+1);
		$('html, body').animate({
			scrollTop: $('#'+hash).offset().top
		}, 250);
		return false;
	});	
	
	$( ".app-nav" ).click(function() {
		event.preventDefault();
		$( ".app-nav" ).removeClass("active");
		$(this).addClass("active");
		console.log("click");
		
		$( ".tab-pane" ).removeClass("active");
		var tab_id = $(this).attr("id");
		$("."+tab_id).addClass("active");
		
	});
	
	//$( "#other" ).click(function() {
	
	$( ".expand.btn" ).click(function() {
		event.preventDefault();
		$( ".contactpanel" ).slideToggle(800, "swing");
	});
	
	// adapt for multiple expanders per page
	// class list should begin with "expand-"
	// the selector of the panel to expand shoudl appear after the -
	// eg expand-panel1
	$( "[class^=expand-]" ).click(function() {

		event.preventDefault();			
		
		var classes = $(this).attr('class');
		var pos = $(this).attr('class').indexOf("expand-");
		var classarray = classes.split(" ");
		var selector = classarray[pos];
		var selarray = selector.split("-");
		var panelselectorname = selarray[1];
		var displayvalue = $("."+panelselectorname).is(':visible');

		if ($(this).text() == "Read More" || $(this).text() == "Read Less") {
		
			if ( displayvalue != true ) {
				$(this).text("Read Less");
			} else {
				$(this).text("Read More");
			}
		
		} else {
			//console.log($(this).children(".faq-symbol").text());
			
			if ($(this).find(".faq-symbol").text() == "+" || $(this).find(".faq-symbol").text() == "-") {
			
				if ( displayvalue != true ) {
					$(this).find(".faq-symbol").text("-");
				} else {
					$(this).find(".faq-symbol").text("+");
				}			
			}
			
		}

		$( "."+panelselectorname ).slideToggle(800, "swing");

	});	
	
	/* 360 viewer */
	
	var productViewer = function(element) {
		this.element = element;
		this.handleContainer = this.element.find('.cd-product-viewer-handle');
		this.handleFill = this.handleContainer.children('.fill');
		this.handle = this.handleContainer.children('.handle');
		this.imageWrapper = this.element.find('.product-viewer');
		this.slideShow = this.imageWrapper.children('.product-sprite');
		this.frames = this.element.data('frame');
		//increase this value to increase the friction while dragging on the image - it has to be bigger than zero
		this.friction = this.element.data('friction');
		this.visibleFrame = 0;
		this.loaded = false;
		this.animating = false;
		this.xPosition = 0;
		this.loadFrames();
	} 

	productViewer.prototype.loadFrames = function() {
		var self = this,
			imageUrl = this.slideShow.data('image'),
			newImg = $('<img/>');
		this.loading('0.5');
		//you need this to check if the image sprite has been loaded
		newImg.attr('src', imageUrl).load(function() {
			$(this).remove();
  			self.loaded = true;
  		}).each(function(){
  			image = this;
			if(image.complete) {
		    	$(image).trigger('load');
		  	}
		});
	}

	productViewer.prototype.loading = function(percentage) {
		var self = this;
		transformElement(this.handleFill, 'scaleX('+ percentage +')');
		setTimeout(function(){
			if( self.loaded ){
				//sprite image has been loaded
				self.element.addClass('loaded');
				transformElement(self.handleFill, 'scaleX(1)');
				self.dragImage();
				if(self.handle) self.dragHandle();
			} else {
				//sprite image has not been loaded - increase self.handleFill scale value
				var newPercentage = parseFloat(percentage) + .1;
				if ( newPercentage < 1 ) {
					self.loading(newPercentage);
				} else {
					self.loading(parseFloat(percentage));
				}
			}
		}, 500);
	}
	//draggable funtionality - credits to http://css-tricks.com/snippets/jquery/draggable-without-jquery-ui/
	productViewer.prototype.dragHandle = function() {
		//implement handle draggability
		var self = this;
		self.handle.on('mousedown vmousedown', function (e) {
	        self.handle.addClass('cd-draggable');
	        var dragWidth = self.handle.outerWidth(),
	            containerOffset = self.handleContainer.offset().left,
	            containerWidth = self.handleContainer.outerWidth(),
	            minLeft = containerOffset - dragWidth/2,
	            maxLeft = containerOffset + containerWidth - dragWidth/2;

	        self.xPosition = self.handle.offset().left + dragWidth - e.pageX;

	        self.element.on('mousemove vmousemove', function (e) {
	        	if( !self.animating) {
	        		self.animating =  true;
		        	( !window.requestAnimationFrame )
		        		? setTimeout(function(){self.animateDraggedHandle(e, dragWidth, containerOffset, containerWidth, minLeft, maxLeft);}, 100)
		        		: requestAnimationFrame(function(){self.animateDraggedHandle(e, dragWidth, containerOffset, containerWidth, minLeft, maxLeft);});
	        	}
	        }).one('mouseup vmouseup', function (e) {
	            self.handle.removeClass('cd-draggable');
	            self.element.off('mousemove vmousemove');
	        });

	        e.preventDefault();

	    }).on('mouseup vmouseup', function (e) {
	        self.handle.removeClass('cd-draggable');
	    });
	}

	productViewer.prototype.animateDraggedHandle = function(e, dragWidth, containerOffset, containerWidth, minLeft, maxLeft) {
		var self = this;
		var leftValue = e.pageX + self.xPosition - dragWidth;
	    // constrain the draggable element to move inside his container
	    if (leftValue < minLeft) {
	        leftValue = minLeft;
	    } else if (leftValue > maxLeft) {
	        leftValue = maxLeft;
	    }

	    var widthValue = Math.ceil( (leftValue + dragWidth / 2 - containerOffset) * 1000 / containerWidth)/10;
	    self.visibleFrame = Math.ceil( (widthValue * (self.frames-1))/100 );

	    //update image frame
	    self.updateFrame();
	    //update handle position
	    $('.cd-draggable', self.handleContainer).css('left', widthValue + '%').one('mouseup vmouseup', function () {
	        $(this).removeClass('cd-draggable');
	    });

	    self.animating = false;
	}

	productViewer.prototype.dragImage = function() {
		//implement image draggability
		var self = this;
		self.slideShow.on('mousedown vmousedown', function (e) {
	        self.slideShow.addClass('cd-draggable');
	        var containerOffset = self.imageWrapper.offset().left,
	            containerWidth = self.imageWrapper.outerWidth(),
	            minFrame = 0,
	            maxFrame = self.frames - 1;

	        self.xPosition = e.pageX;

	        self.element.on('mousemove vmousemove', function (e) {
	        	if( !self.animating) {
	        		self.animating =  true;
		        	( !window.requestAnimationFrame )
		        		? setTimeout(function(){self.animateDraggedImage(e, containerOffset, containerWidth);}, 100)
		        		: requestAnimationFrame(function(){self.animateDraggedImage(e, containerOffset, containerWidth);});
		        }
	        }).one('mouseup vmouseup', function (e) {
	            self.slideShow.removeClass('cd-draggable');
	            self.element.off('mousemove vmousemove');
	            self.updateHandle();
	        });

	        e.preventDefault();

	    }).on('mouseup vmouseup', function (e) {
	        self.slideShow.removeClass('cd-draggable');
	    });
	}

	productViewer.prototype.animateDraggedImage = function(e, containerOffset, containerWidth) {
		var self = this;
		var leftValue = self.xPosition - e.pageX;
        var widthValue = Math.ceil( (leftValue) * 100 / ( containerWidth * self.friction ));
        var frame = (widthValue * (self.frames-1))/100;
        if( frame > 0 ) {
        	frame = Math.floor(frame);
        } else {
        	frame = Math.ceil(frame);
        }
        var newFrame = self.visibleFrame + frame;

        if (newFrame < 0) {
            newFrame = self.frames - 1;
        } else if (newFrame > self.frames - 1) {
            newFrame = 0;
        }

        if( newFrame != self.visibleFrame ) {
        	self.visibleFrame = newFrame;
        	self.updateFrame();
        	self.xPosition = e.pageX;
        }

        self.animating =  false;
	}

	productViewer.prototype.updateHandle = function() {
		if(this.handle) {
			var widthValue = 100*this.visibleFrame/this.frames;
			this.handle.animate({'left': widthValue + '%'}, 200);
		}
	}

	productViewer.prototype.updateFrame = function() {
		var transformValue = - (100 * this.visibleFrame/this.frames);
		transformElement(this.slideShow, 'translateX('+transformValue+'%)');
	}

	function transformElement(element, value) {
		element.css({
			'-moz-transform': value,
		    '-webkit-transform': value,
			'-ms-transform': value,
			'-o-transform': value,
			'transform': value,
		});
	}

	var productToursWrapper = $('.cd-product-viewer-wrapper');
	productToursWrapper.each(function(){
		new productViewer($(this));
	});
	
	
	$('input[value="Draft"] + span.wpcf7-list-item-label').html('<img src="https://thinglab.com.au/wp-content/uploads/2019/07/draft-1.jpg"/>');
	$('input[value="Clear"] + span.wpcf7-list-item-label').html('<img src="https://thinglab.com.au/wp-content/uploads/2019/07/clear.jpg"/>');
	$('input[value="White"] + span.wpcf7-list-item-label').html('<img src="https://thinglab.com.au/wp-content/uploads/2019/07/white.jpg"/>');
	$('input[value="Grey"] + span.wpcf7-list-item-label').html('<img src="https://thinglab.com.au/wp-content/uploads/2019/07/grey.jpg"/>');
	$('input[value="Black"] + span.wpcf7-list-item-label').html('<img src="https://thinglab.com.au/wp-content/uploads/2019/07/black.jpg"/>');
	$('input[value="Tough"] + span.wpcf7-list-item-label').html('<img src="https://thinglab.com.au/wp-content/uploads/2017/03/tough2-1.png"/>');
	$('input[value="Flexible"] + span.wpcf7-list-item-label').html('<img src="https://thinglab.com.au/wp-content/uploads/2019/07/flexible.jpg"/>');
	$('input[value="High_Temp"] + span.wpcf7-list-item-label').html('<img src="https://thinglab.com.au/wp-content/uploads/2017/03/high-temp2-1.png"/>');
	$('input[value="Castable"] + span.wpcf7-list-item-label').html('<img src="https://thinglab.com.au/wp-content/uploads/2017/03/castable2-1.png"/>');
	$('input[value="Wax_Castable"] + span.wpcf7-list-item-label').html('<img src="https://thinglab.com.au/wp-content/uploads/2018/08/castable_wax_sample-2.png"/>');
	$('input[value="Durable"] + span.wpcf7-list-item-label').html('<img src="https://thinglab.com.au/wp-content/uploads/2018/09/durable2-1.png"/>');
	$('input[value="Rigid"] + span.wpcf7-list-item-label').html('<img src="https://thinglab.com.au/wp-content/uploads/2018/07/rigid-sample.png"/>');
	$('input[value="Grey_Pro"] + span.wpcf7-list-item-label').html('<img src="https://thinglab.com.au/wp-content/uploads/2018/07/grey-pro-sample.png"/>');
	
	wpcf7.cached = 0; 

});
// source --> https://vizulab.com.au/wp-content/themes/quark/js/modernizr-min.js?ver=3.5.0 
/*! modernizr 3.5.0 (Custom Build) | MIT *
 * https://modernizr.com/download/?-applicationcache-audio-backgroundblendmode-backgroundcliptext-backgroundsize-bgpositionxy-bgrepeatspace_bgrepeatround-bgsizecover-borderimage-borderradius-boxshadow-boxsizing-canvas-canvastext-checked-cookies-cryptography-cssanimations-csscalc-csschunit-csscolumns-cssescape-cssexunit-cssfilters-cssgradients-cssgrid_cssgridlegacy-csshyphens_softhyphens_softhyphensfind-cssinvalid-cssmask-csspointerevents-csspositionsticky-csspseudoanimations-csspseudotransitions-cssreflections-cssremunit-cssresize-cssscrollbar-csstransforms-csstransforms3d-csstransitions-cssvalid-cssvhunit-cssvmaxunit-cssvminunit-cssvwunit-cubicbezierrange-displaytable-ellipsis-emoji-exiforientation-flexbox-flexboxlegacy-flexboxtweener-flexwrap-fontface-fullscreen-generatedcontent-geolocation-hashchange-hiddenscroll-history-hsla-ie8compat-indexeddb-inlinesvg-input-inputtypes-intl-json-lastchild-localstorage-mediaqueries-multiplebgs-nthchild-objectfit-opacity-overflowscrolling-picture-postmessage-preserve3d-regions-rgba-scrollsnappoints-sessionstorage-shapes-siblinggeneral-smil-subpixelfont-supports-svg-svgasimg-svgclippaths-svgfilters-svgforeignobject-target-templatestrings-textalignlast-textshadow-touchevents-unicoderange-userselect-video-websockets-websqldatabase-webworkers-wrapflow-domprefixes-hasevent-prefixes-setclasses-shiv-testallprops-testprop-teststyles !*/
!function(window,document,undefined){function is(e,t){return typeof e===t}function testRunner(){var e,t,n,r,o,i,s;for(var d in tests)if(tests.hasOwnProperty(d)){if(e=[],t=tests[d],t.name&&(e.push(t.name.toLowerCase()),t.options&&t.options.aliases&&t.options.aliases.length))for(n=0;n<t.options.aliases.length;n++)e.push(t.options.aliases[n].toLowerCase());for(r=is(t.fn,"function")?t.fn():t.fn,o=0;o<e.length;o++)i=e[o],s=i.split("."),1===s.length?Modernizr[s[0]]=r:(!Modernizr[s[0]]||Modernizr[s[0]]instanceof Boolean||(Modernizr[s[0]]=new Boolean(Modernizr[s[0]])),Modernizr[s[0]][s[1]]=r),classes.push((r?"":"no-")+s.join("-"))}}function setClasses(e){var t=docElement.className,n=Modernizr._config.classPrefix||"";if(isSVG&&(t=t.baseVal),Modernizr._config.enableJSClass){var r=new RegExp("(^|\\s)"+n+"no-js(\\s|$)");t=t.replace(r,"$1"+n+"js$2")}Modernizr._config.enableClasses&&(t+=" "+n+e.join(" "+n),isSVG?docElement.className.baseVal=t:docElement.className=t)}function createElement(){return"function"!=typeof document.createElement?document.createElement(arguments[0]):isSVG?document.createElementNS.call(document,"http://www.w3.org/2000/svg",arguments[0]):document.createElement.apply(document,arguments)}function contains(e,t){return!!~(""+e).indexOf(t)}function computedStyle(e,t,n){var r;if("getComputedStyle"in window){r=getComputedStyle.call(window,e,t);var o=window.console;if(null!==r)n&&(r=r.getPropertyValue(n));else if(o){var i=o.error?"error":"log";o[i].call(o,"getComputedStyle returning null, its possible modernizr test results are inaccurate")}}else r=!t&&e.currentStyle&&e.currentStyle[n];return r}function roundedEquals(e,t){return e-1===t||e===t||e+1===t}function cssToDOM(e){return e.replace(/([a-z])-([a-z])/g,function(e,t,n){return t+n.toUpperCase()}).replace(/^-/,"")}function getBody(){var e=document.body;return e||(e=createElement(isSVG?"svg":"body"),e.fake=!0),e}function injectElementWithStyles(e,t,n,r){var o,i,s,d,a="modernizr",l=createElement("div"),c=getBody();if(parseInt(n,10))for(;n--;)s=createElement("div"),s.id=r?r[n]:a+(n+1),l.appendChild(s);return o=createElement("style"),o.type="text/css",o.id="s"+a,(c.fake?c:l).appendChild(o),c.appendChild(l),o.styleSheet?o.styleSheet.cssText=e:o.appendChild(document.createTextNode(e)),l.id=a,c.fake&&(c.style.background="",c.style.overflow="hidden",d=docElement.style.overflow,docElement.style.overflow="hidden",docElement.appendChild(c)),i=t(l,e),c.fake?(c.parentNode.removeChild(c),docElement.style.overflow=d,docElement.offsetHeight):l.parentNode.removeChild(l),!!i}function addTest(e,t){if("object"==typeof e)for(var n in e)hasOwnProp(e,n)&&addTest(n,e[n]);else{e=e.toLowerCase();var r=e.split("."),o=Modernizr[r[0]];if(2==r.length&&(o=o[r[1]]),"undefined"!=typeof o)return Modernizr;t="function"==typeof t?t():t,1==r.length?Modernizr[r[0]]=t:(!Modernizr[r[0]]||Modernizr[r[0]]instanceof Boolean||(Modernizr[r[0]]=new Boolean(Modernizr[r[0]])),Modernizr[r[0]][r[1]]=t),setClasses([(t&&0!=t?"":"no-")+r.join("-")]),Modernizr._trigger(e,t)}return Modernizr}function fnBind(e,t){return function(){return e.apply(t,arguments)}}function testDOMProps(e,t,n){var r;for(var o in e)if(e[o]in t)return n===!1?e[o]:(r=t[e[o]],is(r,"function")?fnBind(r,n||t):r);return!1}function domToCSS(e){return e.replace(/([A-Z])/g,function(e,t){return"-"+t.toLowerCase()}).replace(/^ms-/,"-ms-")}function nativeTestProps(e,t){var n=e.length;if("CSS"in window&&"supports"in window.CSS){for(;n--;)if(window.CSS.supports(domToCSS(e[n]),t))return!0;return!1}if("CSSSupportsRule"in window){for(var r=[];n--;)r.push("("+domToCSS(e[n])+":"+t+")");return r=r.join(" or "),injectElementWithStyles("@supports ("+r+") { #modernizr { position: absolute; } }",function(e){return"absolute"==computedStyle(e,null,"position")})}return undefined}function testProps(e,t,n,r){function o(){s&&(delete mStyle.style,delete mStyle.modElem)}if(r=is(r,"undefined")?!1:r,!is(n,"undefined")){var i=nativeTestProps(e,n);if(!is(i,"undefined"))return i}for(var s,d,a,l,c,u=["modernizr","tspan","samp"];!mStyle.style&&u.length;)s=!0,mStyle.modElem=createElement(u.shift()),mStyle.style=mStyle.modElem.style;for(a=e.length,d=0;a>d;d++)if(l=e[d],c=mStyle.style[l],contains(l,"-")&&(l=cssToDOM(l)),mStyle.style[l]!==undefined){if(r||is(n,"undefined"))return o(),"pfx"==t?l:!0;try{mStyle.style[l]=n}catch(p){}if(mStyle.style[l]!=c)return o(),"pfx"==t?l:!0}return o(),!1}function testPropsAll(e,t,n,r,o){var i=e.charAt(0).toUpperCase()+e.slice(1),s=(e+" "+cssomPrefixes.join(i+" ")+i).split(" ");return is(t,"string")||is(t,"undefined")?testProps(s,t,r,o):(s=(e+" "+domPrefixes.join(i+" ")+i).split(" "),testDOMProps(s,t,n))}function testAllProps(e,t,n){return testPropsAll(e,undefined,undefined,t,n)}function detectDeleteDatabase(e,t){var n=e.deleteDatabase(t);n.onsuccess=function(){addTest("indexeddb.deletedatabase",!0)},n.onerror=function(){addTest("indexeddb.deletedatabase",!1)}}var classes=[],tests=[],ModernizrProto={_version:"3.5.0",_config:{classPrefix:"",enableClasses:!0,enableJSClass:!0,usePrefixes:!0},_q:[],on:function(e,t){var n=this;setTimeout(function(){t(n[e])},0)},addTest:function(e,t,n){tests.push({name:e,fn:t,options:n})},addAsyncTest:function(e){tests.push({name:null,fn:e})}},Modernizr=function(){};Modernizr.prototype=ModernizrProto,Modernizr=new Modernizr,Modernizr.addTest("applicationcache","applicationCache"in window),Modernizr.addTest("cookies",function(){try{document.cookie="cookietest=1";var e=-1!=document.cookie.indexOf("cookietest=");return document.cookie="cookietest=1; expires=Thu, 01-Jan-1970 00:00:01 GMT",e}catch(t){return!1}}),Modernizr.addTest("geolocation","geolocation"in navigator),Modernizr.addTest("history",function(){var e=navigator.userAgent;return-1===e.indexOf("Android 2.")&&-1===e.indexOf("Android 4.0")||-1===e.indexOf("Mobile Safari")||-1!==e.indexOf("Chrome")||-1!==e.indexOf("Windows Phone")||"file:"===location.protocol?window.history&&"pushState"in window.history:!1}),Modernizr.addTest("ie8compat",!window.addEventListener&&!!document.documentMode&&7===document.documentMode),Modernizr.addTest("json","JSON"in window&&"parse"in JSON&&"stringify"in JSON),Modernizr.addTest("postmessage","postMessage"in window),Modernizr.addTest("svg",!!document.createElementNS&&!!document.createElementNS("http://www.w3.org/2000/svg","svg").createSVGRect),Modernizr.addTest("templatestrings",function(){var supports;try{eval("``"),supports=!0}catch(e){}return!!supports});var supports=!1;try{supports="WebSocket"in window&&2===window.WebSocket.CLOSING}catch(e){}Modernizr.addTest("websockets",supports);var CSS=window.CSS;Modernizr.addTest("cssescape",CSS?"function"==typeof CSS.escape:!1);var newSyntax="CSS"in window&&"supports"in window.CSS,oldSyntax="supportsCSS"in window;Modernizr.addTest("supports",newSyntax||oldSyntax),Modernizr.addTest("target",function(){var e=window.document;if(!("querySelectorAll"in e))return!1;try{return e.querySelectorAll(":target"),!0}catch(t){return!1}}),Modernizr.addTest("picture","HTMLPictureElement"in window),Modernizr.addTest("localstorage",function(){var e="modernizr";try{return localStorage.setItem(e,e),localStorage.removeItem(e),!0}catch(t){return!1}}),Modernizr.addTest("sessionstorage",function(){var e="modernizr";try{return sessionStorage.setItem(e,e),sessionStorage.removeItem(e),!0}catch(t){return!1}}),Modernizr.addTest("websqldatabase","openDatabase"in window),Modernizr.addTest("svgfilters",function(){var e=!1;try{e="SVGFEColorMatrixElement"in window&&2==SVGFEColorMatrixElement.SVG_FECOLORMATRIX_TYPE_SATURATE}catch(t){}return e}),Modernizr.addTest("webworkers","Worker"in window);var prefixes=ModernizrProto._config.usePrefixes?" -webkit- -moz- -o- -ms- ".split(" "):["",""];ModernizrProto._prefixes=prefixes;var docElement=document.documentElement,isSVG="svg"===docElement.nodeName.toLowerCase(),html5;isSVG||!function(e,t){function n(e,t){var n=e.createElement("p"),r=e.getElementsByTagName("head")[0]||e.documentElement;return n.innerHTML="x<style>"+t+"</style>",r.insertBefore(n.lastChild,r.firstChild)}function r(){var e=w.elements;return"string"==typeof e?e.split(" "):e}function o(e,t){var n=w.elements;"string"!=typeof n&&(n=n.join(" ")),"string"!=typeof e&&(e=e.join(" ")),w.elements=n+" "+e,l(t)}function i(e){var t=v[e[g]];return t||(t={},y++,e[g]=y,v[y]=t),t}function s(e,n,r){if(n||(n=t),u)return n.createElement(e);r||(r=i(n));var o;return o=r.cache[e]?r.cache[e].cloneNode():h.test(e)?(r.cache[e]=r.createElem(e)).cloneNode():r.createElem(e),!o.canHaveChildren||m.test(e)||o.tagUrn?o:r.frag.appendChild(o)}function d(e,n){if(e||(e=t),u)return e.createDocumentFragment();n=n||i(e);for(var o=n.frag.cloneNode(),s=0,d=r(),a=d.length;a>s;s++)o.createElement(d[s]);return o}function a(e,t){t.cache||(t.cache={},t.createElem=e.createElement,t.createFrag=e.createDocumentFragment,t.frag=t.createFrag()),e.createElement=function(n){return w.shivMethods?s(n,e,t):t.createElem(n)},e.createDocumentFragment=Function("h,f","return function(){var n=f.cloneNode(),c=n.createElement;h.shivMethods&&("+r().join().replace(/[\w\-:]+/g,function(e){return t.createElem(e),t.frag.createElement(e),'c("'+e+'")'})+");return n}")(w,t.frag)}function l(e){e||(e=t);var r=i(e);return!w.shivCSS||c||r.hasCSS||(r.hasCSS=!!n(e,"article,aside,dialog,figcaption,figure,footer,header,hgroup,main,nav,section{display:block}mark{background:#FF0;color:#000}template{display:none}")),u||a(e,r),e}var c,u,p="3.7.3",f=e.html5||{},m=/^<|^(?:button|map|select|textarea|object|iframe|option|optgroup)$/i,h=/^(?:a|b|code|div|fieldset|h1|h2|h3|h4|h5|h6|i|label|li|ol|p|q|span|strong|style|table|tbody|td|th|tr|ul)$/i,g="_html5shiv",y=0,v={};!function(){try{var e=t.createElement("a");e.innerHTML="<xyz></xyz>",c="hidden"in e,u=1==e.childNodes.length||function(){t.createElement("a");var e=t.createDocumentFragment();return"undefined"==typeof e.cloneNode||"undefined"==typeof e.createDocumentFragment||"undefined"==typeof e.createElement}()}catch(n){c=!0,u=!0}}();var w={elements:f.elements||"abbr article aside audio bdi canvas data datalist details dialog figcaption figure footer header hgroup main mark meter nav output picture progress section summary template time video",version:p,shivCSS:f.shivCSS!==!1,supportsUnknownElements:u,shivMethods:f.shivMethods!==!1,type:"default",shivDocument:l,createElement:s,createDocumentFragment:d,addElements:o};e.html5=w,l(t),"object"==typeof module&&module.exports&&(module.exports=w)}("undefined"!=typeof window?window:this,document);var omPrefixes="Moz O ms Webkit",domPrefixes=ModernizrProto._config.usePrefixes?omPrefixes.toLowerCase().split(" "):[];ModernizrProto._domPrefixes=domPrefixes;var hasEvent=function(){function e(e,n){var r;return e?(n&&"string"!=typeof n||(n=createElement(n||"div")),e="on"+e,r=e in n,!r&&t&&(n.setAttribute||(n=createElement("div")),n.setAttribute(e,""),r="function"==typeof n[e],n[e]!==undefined&&(n[e]=undefined),n.removeAttribute(e)),r):!1}var t=!("onblur"in document.documentElement);return e}();ModernizrProto.hasEvent=hasEvent,Modernizr.addTest("hashchange",function(){return hasEvent("hashchange",window)===!1?!1:document.documentMode===undefined||document.documentMode>7}),Modernizr.addTest("audio",function(){var e=createElement("audio"),t=!1;try{t=!!e.canPlayType,t&&(t=new Boolean(t),t.ogg=e.canPlayType('audio/ogg; codecs="vorbis"').replace(/^no$/,""),t.mp3=e.canPlayType('audio/mpeg; codecs="mp3"').replace(/^no$/,""),t.opus=e.canPlayType('audio/ogg; codecs="opus"')||e.canPlayType('audio/webm; codecs="opus"').replace(/^no$/,""),t.wav=e.canPlayType('audio/wav; codecs="1"').replace(/^no$/,""),t.m4a=(e.canPlayType("audio/x-m4a;")||e.canPlayType("audio/aac;")).replace(/^no$/,""))}catch(n){}return t}),Modernizr.addTest("canvas",function(){var e=createElement("canvas");return!(!e.getContext||!e.getContext("2d"))}),Modernizr.addTest("canvastext",function(){return Modernizr.canvas===!1?!1:"function"==typeof createElement("canvas").getContext("2d").fillText}),Modernizr.addTest("emoji",function(){if(!Modernizr.canvastext)return!1;var e=window.devicePixelRatio||1,t=12*e,n=createElement("canvas"),r=n.getContext("2d");return r.fillStyle="#f00",r.textBaseline="top",r.font="32px Arial",r.fillText("????",0,0),0!==r.getImageData(t,t,1,1).data[0]}),Modernizr.addTest("video",function(){var e=createElement("video"),t=!1;try{t=!!e.canPlayType,t&&(t=new Boolean(t),t.ogg=e.canPlayType('video/ogg; codecs="theora"').replace(/^no$/,""),t.h264=e.canPlayType('video/mp4; codecs="avc1.42E01E"').replace(/^no$/,""),t.webm=e.canPlayType('video/webm; codecs="vp8, vorbis"').replace(/^no$/,""),t.vp9=e.canPlayType('video/webm; codecs="vp9"').replace(/^no$/,""),t.hls=e.canPlayType('application/x-mpegURL; codecs="avc1.42E01E"').replace(/^no$/,""))}catch(n){}return t}),Modernizr.addTest("csscalc",function(){var e="width:",t="calc(10px);",n=createElement("a");return n.style.cssText=e+prefixes.join(t+e),!!n.style.length}),Modernizr.addTest("cubicbezierrange",function(){var e=createElement("a");return e.style.cssText=prefixes.join("transition-timing-function:cubic-bezier(1,0,0,1.1); "),!!e.style.length}),Modernizr.addTest("cssgradients",function(){for(var e,t="background-image:",n="gradient(linear,left top,right bottom,from(#9f9),to(white));",r="",o=0,i=prefixes.length-1;i>o;o++)e=0===o?"to ":"",r+=t+prefixes[o]+"linear-gradient("+e+"left top, #9f9, white);";Modernizr._config.usePrefixes&&(r+=t+"-webkit-"+n);var s=createElement("a"),d=s.style;return d.cssText=r,(""+d.backgroundImage).indexOf("gradient")>-1}),Modernizr.addTest("multiplebgs",function(){var e=createElement("a").style;return e.cssText="background:url(https://),url(https://),red url(https://)",/(url\s*\(.*?){3}/.test(e.background)}),Modernizr.addTest("opacity",function(){var e=createElement("a").style;return e.cssText=prefixes.join("opacity:.55;"),/^0.55$/.test(e.opacity)}),Modernizr.addTest("csspointerevents",function(){var e=createElement("a").style;return e.cssText="pointer-events:auto","auto"===e.pointerEvents}),Modernizr.addTest("csspositionsticky",function(){var e="position:",t="sticky",n=createElement("a"),r=n.style;return r.cssText=e+prefixes.join(t+";"+e).slice(0,-e.length),-1!==r.position.indexOf(t)}),Modernizr.addTest("cssremunit",function(){var e=createElement("a").style;try{e.fontSize="3rem"}catch(t){}return/rem/.test(e.fontSize)}),Modernizr.addTest("rgba",function(){var e=createElement("a").style;return e.cssText="background-color:rgba(150,255,150,.5)",(""+e.backgroundColor).indexOf("rgba")>-1}),Modernizr.addTest("preserve3d",function(){var e,t,n=window.CSS,r=!1;return n&&n.supports&&n.supports("(transform-style: preserve-3d)")?!0:(e=createElement("a"),t=createElement("a"),e.style.cssText="display: block; transform-style: preserve-3d; transform-origin: right; transform: rotateY(40deg);",t.style.cssText="display: block; width: 9px; height: 1px; background: #000; transform-origin: right; transform: rotateY(40deg);",e.appendChild(t),docElement.appendChild(e),r=t.getBoundingClientRect(),docElement.removeChild(e),r=r.width&&r.width<4)}),Modernizr.addTest("inlinesvg",function(){var e=createElement("div");return e.innerHTML="<svg/>","http://www.w3.org/2000/svg"==("undefined"!=typeof SVGRect&&e.firstChild&&e.firstChild.namespaceURI)});var inputElem=createElement("input"),inputattrs="autocomplete autofocus list placeholder max min multiple pattern required step".split(" "),attrs={};Modernizr.input=function(e){for(var t=0,n=e.length;n>t;t++)attrs[e[t]]=!!(e[t]in inputElem);return attrs.list&&(attrs.list=!(!createElement("datalist")||!window.HTMLDataListElement)),attrs}(inputattrs);var inputtypes="search tel url email datetime date month week time datetime-local number range color".split(" "),inputs={};Modernizr.inputtypes=function(e){for(var t,n,r,o=e.length,i="1)",s=0;o>s;s++)inputElem.setAttribute("type",t=e[s]),r="text"!==inputElem.type&&"style"in inputElem,r&&(inputElem.value=i,inputElem.style.cssText="position:absolute;visibility:hidden;",/^range$/.test(t)&&inputElem.style.WebkitAppearance!==undefined?(docElement.appendChild(inputElem),n=document.defaultView,r=n.getComputedStyle&&"textfield"!==n.getComputedStyle(inputElem,null).WebkitAppearance&&0!==inputElem.offsetHeight,docElement.removeChild(inputElem)):/^(search|tel)$/.test(t)||(r=/^(url|email)$/.test(t)?inputElem.checkValidity&&inputElem.checkValidity()===!1:inputElem.value!=i)),inputs[e[s]]=!!r;return inputs}(inputtypes);var modElem={elem:createElement("modernizr")};Modernizr._q.push(function(){delete modElem.elem}),Modernizr.addTest("csschunit",function(){var e,t=modElem.elem.style;try{t.fontSize="3ch",e=-1!==t.fontSize.indexOf("ch")}catch(n){e=!1}return e}),Modernizr.addTest("cssexunit",function(){var e,t=modElem.elem.style;try{t.fontSize="3ex",e=-1!==t.fontSize.indexOf("ex")}catch(n){e=!1}return e}),Modernizr.addTest("hsla",function(){var e=createElement("a").style;return e.cssText="background-color:hsla(120,40%,100%,.5)",contains(e.backgroundColor,"rgba")||contains(e.backgroundColor,"hsla")});var toStringFn={}.toString;Modernizr.addTest("svgclippaths",function(){return!!document.createElementNS&&/SVGClipPath/.test(toStringFn.call(document.createElementNS("http://www.w3.org/2000/svg","clipPath")))}),Modernizr.addTest("svgforeignobject",function(){return!!document.createElementNS&&/SVGForeignObject/.test(toStringFn.call(document.createElementNS("http://www.w3.org/2000/svg","foreignObject")))}),Modernizr.addTest("smil",function(){return!!document.createElementNS&&/SVGAnimate/.test(toStringFn.call(document.createElementNS("http://www.w3.org/2000/svg","animate")))});var cssomPrefixes=ModernizrProto._config.usePrefixes?omPrefixes.split(" "):[];ModernizrProto._cssomPrefixes=cssomPrefixes;var mStyle={style:modElem.elem.style};Modernizr._q.unshift(function(){delete mStyle.style});var testStyles=ModernizrProto.testStyles=injectElementWithStyles;Modernizr.addTest("hiddenscroll",function(){return testStyles("#modernizr {width:100px;height:100px;overflow:scroll}",function(e){return e.offsetWidth===e.clientWidth})}),Modernizr.addTest("touchevents",function(){var e;if("ontouchstart"in window||window.DocumentTouch&&document instanceof DocumentTouch)e=!0;else{var t=["@media (",prefixes.join("touch-enabled),("),"heartz",")","{#modernizr{top:9px;position:absolute}}"].join("");testStyles(t,function(t){e=9===t.offsetTop})}return e}),Modernizr.addTest("unicoderange",function(){return Modernizr.testStyles('@font-face{font-family:"unicodeRange";src:local("Arial");unicode-range:U+0020,U+002E}#modernizr span{font-size:20px;display:inline-block;font-family:"unicodeRange",monospace}#modernizr .mono{font-family:monospace}',function(e){for(var t=[".",".","m","m"],n=0;n<t.length;n++){var r=createElement("span");r.innerHTML=t[n],r.className=n%2?"mono":"",e.appendChild(r),t[n]=r.clientWidth}return t[0]!==t[1]&&t[2]===t[3]})}),Modernizr.addTest("checked",function(){return testStyles("#modernizr {position:absolute} #modernizr input {margin-left:10px} #modernizr :checked {margin-left:20px;display:block}",function(e){var t=createElement("input");return t.setAttribute("type","checkbox"),t.setAttribute("checked","checked"),e.appendChild(t),20===t.offsetLeft})}),testStyles("#modernizr{display: table; direction: ltr}#modernizr div{display: table-cell; padding: 10px}",function(e){var t,n=e.childNodes;t=n[0].offsetLeft<n[1].offsetLeft,Modernizr.addTest("displaytable",t,{aliases:["display-table"]})},2);var blacklist=function(){var e=navigator.userAgent,t=e.match(/w(eb)?osbrowser/gi),n=e.match(/windows phone/gi)&&e.match(/iemobile\/([0-9])+/gi)&&parseFloat(RegExp.$1)>=9;return t||n}();blacklist?Modernizr.addTest("fontface",!1):testStyles('@font-face {font-family:"font";src:url("https://")}',function(e,t){var n=document.getElementById("smodernizr"),r=n.sheet||n.styleSheet,o=r?r.cssRules&&r.cssRules[0]?r.cssRules[0].cssText:r.cssText||"":"",i=/src/i.test(o)&&0===o.indexOf(t.split(" ")[0]);Modernizr.addTest("fontface",i)}),testStyles('#modernizr{font:0/0 a}#modernizr:after{content:":)";visibility:hidden;font:7px/1 a}',function(e){Modernizr.addTest("generatedcontent",e.offsetHeight>=6)}),Modernizr.addTest("cssinvalid",function(){return testStyles("#modernizr input{height:0;border:0;padding:0;margin:0;width:10px} #modernizr input:invalid{width:50px}",function(e){var t=createElement("input");return t.required=!0,e.appendChild(t),t.clientWidth>10})}),testStyles("#modernizr div {width:100px} #modernizr :last-child{width:200px;display:block}",function(e){Modernizr.addTest("lastchild",e.lastChild.offsetWidth>e.firstChild.offsetWidth)},2),testStyles("#modernizr div {width:1px} #modernizr div:nth-child(2n) {width:2px;}",function(e){for(var t=e.getElementsByTagName("div"),n=!0,r=0;5>r;r++)n=n&&t[r].offsetWidth===r%2+1;Modernizr.addTest("nthchild",n)},5),testStyles("#modernizr{overflow: scroll; width: 40px; height: 40px; }#"+prefixes.join("scrollbar{width:10px} #modernizr::").split("#").slice(1).join("#")+"scrollbar{width:10px}",function(e){Modernizr.addTest("cssscrollbar","scrollWidth"in e&&30==e.scrollWidth)}),Modernizr.addTest("siblinggeneral",function(){return testStyles("#modernizr div {width:100px} #modernizr div ~ div {width:200px;display:block}",function(e){return 200==e.lastChild.offsetWidth},2)}),testStyles("#modernizr{position: absolute; top: -10em; visibility:hidden; font: normal 10px arial;}#subpixel{float: left; font-size: 33.3333%;}",function(e){var t=e.firstChild;t.innerHTML="This is a text written in Arial",Modernizr.addTest("subpixelfont",window.getComputedStyle?"44px"!==window.getComputedStyle(t,null).getPropertyValue("width"):!1)},1,["subpixel"]),Modernizr.addTest("cssvalid",function(){return testStyles("#modernizr input{height:0;border:0;padding:0;margin:0;width:10px} #modernizr input:valid{width:50px}",function(e){var t=createElement("input");return e.appendChild(t),t.clientWidth>10})}),testStyles("#modernizr { height: 50vh; }",function(e){var t=parseInt(window.innerHeight/2,10),n=parseInt(computedStyle(e,null,"height"),10);Modernizr.addTest("cssvhunit",n==t)}),testStyles("#modernizr1{width: 50vmax}#modernizr2{width:50px;height:50px;overflow:scroll}#modernizr3{position:fixed;top:0;left:0;bottom:0;right:0}",function(e){var t=e.childNodes[2],n=e.childNodes[1],r=e.childNodes[0],o=parseInt((n.offsetWidth-n.clientWidth)/2,10),i=r.clientWidth/100,s=r.clientHeight/100,d=parseInt(50*Math.max(i,s),10),a=parseInt(computedStyle(t,null,"width"),10);Modernizr.addTest("cssvmaxunit",roundedEquals(d,a)||roundedEquals(d,a-o))},3),testStyles("#modernizr1{width: 50vm;width:50vmin}#modernizr2{width:50px;height:50px;overflow:scroll}#modernizr3{position:fixed;top:0;left:0;bottom:0;right:0}",function(e){var t=e.childNodes[2],n=e.childNodes[1],r=e.childNodes[0],o=parseInt((n.offsetWidth-n.clientWidth)/2,10),i=r.clientWidth/100,s=r.clientHeight/100,d=parseInt(50*Math.min(i,s),10),a=parseInt(computedStyle(t,null,"width"),10);Modernizr.addTest("cssvminunit",roundedEquals(d,a)||roundedEquals(d,a-o))},3),testStyles("#modernizr { width: 50vw; }",function(e){var t=parseInt(window.innerWidth/2,10),n=parseInt(computedStyle(e,null,"width"),10);Modernizr.addTest("cssvwunit",n==t)});var mq=function(){var e=window.matchMedia||window.msMatchMedia;return e?function(t){var n=e(t);return n&&n.matches||!1}:function(e){var t=!1;return injectElementWithStyles("@media "+e+" { #modernizr { position: absolute; } }",function(e){t="absolute"==(window.getComputedStyle?window.getComputedStyle(e,null):e.currentStyle).position}),t}}();ModernizrProto.mq=mq,Modernizr.addTest("mediaqueries",mq("only all"));var atRule=function(e){var t,n=prefixes.length,r=window.CSSRule;if("undefined"==typeof r)return undefined;if(!e)return!1;if(e=e.replace(/^@/,""),t=e.replace(/-/g,"_").toUpperCase()+"_RULE",t in r)return"@"+e;for(var o=0;n>o;o++){var i=prefixes[o],s=i.toUpperCase()+"_"+t;if(s in r)return"@-"+i.toLowerCase()+"-"+e}return!1};ModernizrProto.atRule=atRule;var hasOwnProp;!function(){var e={}.hasOwnProperty;hasOwnProp=is(e,"undefined")||is(e.call,"undefined")?function(e,t){return t in e&&is(e.constructor.prototype[t],"undefined")}:function(t,n){return e.call(t,n)}}(),ModernizrProto._l={},ModernizrProto.on=function(e,t){this._l[e]||(this._l[e]=[]),this._l[e].push(t),Modernizr.hasOwnProperty(e)&&setTimeout(function(){Modernizr._trigger(e,Modernizr[e])},0)},ModernizrProto._trigger=function(e,t){if(this._l[e]){var n=this._l[e];setTimeout(function(){var e,r;for(e=0;e<n.length;e++)(r=n[e])(t)},0),delete this._l[e]}},Modernizr._q.push(function(){ModernizrProto.addTest=addTest}),Modernizr.addAsyncTest(function(){var e=new Image;e.onerror=function(){addTest("exiforientation",!1,{aliases:["exif-orientation"]})},e.onload=function(){addTest("exiforientation",2!==e.width,{aliases:["exif-orientation"]})},e.src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQEAYABgAAD/4QAiRXhpZgAASUkqAAgAAAABABIBAwABAAAABgASAAAAAAD/2wBDAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/2wBDAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/wAARCAABAAIDASIAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwD+/iiiigD/2Q=="}),Modernizr.addTest("svgasimg",document.implementation.hasFeature("http://www.w3.org/TR/SVG11/feature#Image","1.1"));var testProp=ModernizrProto.testProp=function(e,t,n){return testProps([e],undefined,t,n)};Modernizr.addTest("textshadow",testProp("textShadow","1px 1px")),ModernizrProto.testAllProps=testPropsAll,ModernizrProto.testAllProps=testAllProps,Modernizr.addTest("cssanimations",testAllProps("animationName","a",!0)),Modernizr.addTest("csspseudoanimations",function(){var e=!1;if(!Modernizr.cssanimations||!window.getComputedStyle)return e;var t=["@",Modernizr._prefixes.join("keyframes csspseudoanimations { from { font-size: 10px; } }@").replace(/\@$/,""),'#modernizr:before { content:" "; font-size:5px;',Modernizr._prefixes.join("animation:csspseudoanimations 1ms infinite;"),"}"].join("");return Modernizr.testStyles(t,function(t){e="10px"===window.getComputedStyle(t,":before").getPropertyValue("font-size")}),e}),Modernizr.addTest("backgroundcliptext",function(){return testAllProps("backgroundClip","text")}),Modernizr.addTest("bgpositionxy",function(){return testAllProps("backgroundPositionX","3px",!0)&&testAllProps("backgroundPositionY","5px",!0)}),Modernizr.addTest("bgrepeatround",testAllProps("backgroundRepeat","round")),Modernizr.addTest("bgrepeatspace",testAllProps("backgroundRepeat","space")),Modernizr.addTest("backgroundsize",testAllProps("backgroundSize","100%",!0)),Modernizr.addTest("bgsizecover",testAllProps("backgroundSize","cover")),Modernizr.addTest("borderimage",testAllProps("borderImage","url() 1",!0)),Modernizr.addTest("borderradius",testAllProps("borderRadius","0px",!0)),Modernizr.addTest("boxshadow",testAllProps("boxShadow","1px 1px",!0)),Modernizr.addTest("boxsizing",testAllProps("boxSizing","border-box",!0)&&(document.documentMode===undefined||document.documentMode>7)),function(){Modernizr.addTest("csscolumns",function(){var e=!1,t=testAllProps("columnCount");try{e=!!t,e&&(e=new Boolean(e))}catch(n){}return e});for(var e,t,n=["Width","Span","Fill","Gap","Rule","RuleColor","RuleStyle","RuleWidth","BreakBefore","BreakAfter","BreakInside"],r=0;r<n.length;r++)e=n[r].toLowerCase(),t=testAllProps("column"+n[r]),("breakbefore"===e||"breakafter"===e||"breakinside"==e)&&(t=t||testAllProps(n[r])),Modernizr.addTest("csscolumns."+e,t)}(),Modernizr.addTest("cssgridlegacy",testAllProps("grid-columns","10px",!0)),Modernizr.addTest("cssgrid",testAllProps("grid-template-rows","none",!0)),Modernizr.addTest("ellipsis",testAllProps("textOverflow","ellipsis")),Modernizr.addTest("cssfilters",function(){if(Modernizr.supports)return testAllProps("filter","blur(2px)");var e=createElement("a");return e.style.cssText=prefixes.join("filter:blur(2px); "),!!e.style.length&&(document.documentMode===undefined||document.documentMode>9)}),Modernizr.addTest("flexbox",testAllProps("flexBasis","1px",!0)),Modernizr.addTest("flexboxlegacy",testAllProps("boxDirection","reverse",!0)),Modernizr.addTest("flexboxtweener",testAllProps("flexAlign","end",!0)),Modernizr.addTest("flexwrap",testAllProps("flexWrap","wrap",!0)),Modernizr.addAsyncTest(function(){function e(){function n(){try{var e=createElement("div"),t=createElement("span"),n=e.style,r=0,o=0,i=!1,s=document.body.firstElementChild||document.body.firstChild;return e.appendChild(t),t.innerHTML="Bacon ipsum dolor sit amet jerky velit in culpa hamburger et. Laborum dolor proident, enim dolore duis commodo et strip steak. Salami anim et, veniam consectetur dolore qui tenderloin jowl velit sirloin. Et ad culpa, fatback cillum jowl ball tip ham hock nulla short ribs pariatur aute. Pig pancetta ham bresaola, ut boudin nostrud commodo flank esse cow tongue culpa. Pork belly bresaola enim pig, ea consectetur nisi. Fugiat officia turkey, ea cow jowl pariatur ullamco proident do laborum velit sausage. Magna biltong sint tri-tip commodo sed bacon, esse proident aliquip. Ullamco ham sint fugiat, velit in enim sed mollit nulla cow ut adipisicing nostrud consectetur. Proident dolore beef ribs, laborum nostrud meatball ea laboris rump cupidatat labore culpa. Shankle minim beef, velit sint cupidatat fugiat tenderloin pig et ball tip. Ut cow fatback salami, bacon ball tip et in shank strip steak bresaola. In ut pork belly sed mollit tri-tip magna culpa veniam, short ribs qui in andouille ham consequat. Dolore bacon t-bone, velit short ribs enim strip steak nulla. Voluptate labore ut, biltong swine irure jerky. Cupidatat excepteur aliquip salami dolore. Ball tip strip steak in pork dolor. Ad in esse biltong. Dolore tenderloin exercitation ad pork loin t-bone, dolore in chicken ball tip qui pig. Ut culpa tongue, sint ribeye dolore ex shank voluptate hamburger. Jowl et tempor, boudin pork chop labore ham hock drumstick consectetur tri-tip elit swine meatball chicken ground round. Proident shankle mollit dolore. Shoulder ut duis t-bone quis reprehenderit. Meatloaf dolore minim strip steak, laboris ea aute bacon beef ribs elit shank in veniam drumstick qui. Ex laboris meatball cow tongue pork belly. Ea ball tip reprehenderit pig, sed fatback boudin dolore flank aliquip laboris eu quis. Beef ribs duis beef, cow corned beef adipisicing commodo nisi deserunt exercitation. Cillum dolor t-bone spare ribs, ham hock est sirloin. Brisket irure meatloaf in, boudin pork belly sirloin ball tip. Sirloin sint irure nisi nostrud aliqua. Nostrud nulla aute, enim officia culpa ham hock. Aliqua reprehenderit dolore sunt nostrud sausage, ea boudin pork loin ut t-bone ham tempor. Tri-tip et pancetta drumstick laborum. Ham hock magna do nostrud in proident. Ex ground round fatback, venison non ribeye in.",document.body.insertBefore(e,s),n.cssText="position:absolute;top:0;left:0;width:5em;text-align:justify;text-justification:newspaper;",r=t.offsetHeight,o=t.offsetWidth,n.cssText="position:absolute;top:0;left:0;width:5em;text-align:justify;text-justification:newspaper;"+prefixes.join("hyphens:auto; "),i=t.offsetHeight!=r||t.offsetWidth!=o,document.body.removeChild(e),e.removeChild(t),i}catch(d){return!1}}function r(e,t){try{var n=createElement("div"),r=createElement("span"),o=n.style,i=0,s=!1,d=!1,a=!1,l=document.body.firstElementChild||document.body.firstChild;return o.cssText="position:absolute;top:0;left:0;overflow:visible;width:1.25em;",n.appendChild(r),document.body.insertBefore(n,l),r.innerHTML="mm",i=r.offsetHeight,
r.innerHTML="m"+e+"m",d=r.offsetHeight>i,t?(r.innerHTML="m<br />m",i=r.offsetWidth,r.innerHTML="m"+e+"m",a=r.offsetWidth>i):a=!0,d===!0&&a===!0&&(s=!0),document.body.removeChild(n),n.removeChild(r),s}catch(c){return!1}}function o(e){try{var t,n=createElement("input"),r=createElement("div"),o="lebowski",i=!1,s=document.body.firstElementChild||document.body.firstChild;r.innerHTML=o+e+o,document.body.insertBefore(r,s),document.body.insertBefore(n,r),n.setSelectionRange?(n.focus(),n.setSelectionRange(0,0)):n.createTextRange&&(t=n.createTextRange(),t.collapse(!0),t.moveEnd("character",0),t.moveStart("character",0),t.select());try{window.find?i=window.find(o+o):(t=window.self.document.body.createTextRange(),i=t.findText(o+o))}catch(d){i=!1}return document.body.removeChild(r),document.body.removeChild(n),i}catch(d){return!1}}return document.body||document.getElementsByTagName("body")[0]?(addTest("csshyphens",function(){if(!testAllProps("hyphens","auto",!0))return!1;try{return n()}catch(e){return!1}}),addTest("softhyphens",function(){try{return r("&#173;",!0)&&r("&#8203;",!1)}catch(e){return!1}}),void addTest("softhyphensfind",function(){try{return o("&#173;")&&o("&#8203;")}catch(e){return!1}})):void setTimeout(e,t)}var t=300;setTimeout(e,t)}),Modernizr.addTest("cssmask",testAllProps("maskRepeat","repeat-x",!0)),Modernizr.addTest("overflowscrolling",testAllProps("overflowScrolling","touch",!0)),Modernizr.addTest("cssreflections",testAllProps("boxReflect","above",!0)),Modernizr.addTest("cssresize",testAllProps("resize","both",!0)),Modernizr.addTest("scrollsnappoints",testAllProps("scrollSnapType")),Modernizr.addTest("shapes",testAllProps("shapeOutside","content-box",!0)),Modernizr.addTest("textalignlast",testAllProps("textAlignLast")),Modernizr.addTest("csstransforms",function(){return-1===navigator.userAgent.indexOf("Android 2.")&&testAllProps("transform","scale(1)",!0)}),Modernizr.addTest("csstransforms3d",function(){var e=!!testAllProps("perspective","1px",!0),t=Modernizr._config.usePrefixes;if(e&&(!t||"webkitPerspective"in docElement.style)){var n,r="#modernizr{width:0;height:0}";Modernizr.supports?n="@supports (perspective: 1px)":(n="@media (transform-3d)",t&&(n+=",(-webkit-transform-3d)")),n+="{#modernizr{width:7px;height:18px;margin:0;padding:0;border:0}}",testStyles(r+n,function(t){e=7===t.offsetWidth&&18===t.offsetHeight})}return e}),Modernizr.addTest("csstransitions",testAllProps("transition","all",!0)),Modernizr.addTest("csspseudotransitions",function(){var e=!1;if(!Modernizr.csstransitions||!window.getComputedStyle)return e;var t='#modernizr:before { content:" "; font-size:5px;'+Modernizr._prefixes.join("transition:0s 100s;")+"}#modernizr.trigger:before { font-size:10px; }";return Modernizr.testStyles(t,function(t){window.getComputedStyle(t,":before").getPropertyValue("font-size"),t.className+="trigger",e="5px"===window.getComputedStyle(t,":before").getPropertyValue("font-size")}),e}),Modernizr.addTest("userselect",testAllProps("userSelect","none",!0));var prefixed=ModernizrProto.prefixed=function(e,t,n){return 0===e.indexOf("@")?atRule(e):(-1!=e.indexOf("-")&&(e=cssToDOM(e)),t?testPropsAll(e,t,n):testPropsAll(e,"pfx"))},crypto=prefixed("crypto",window);Modernizr.addTest("crypto",!!prefixed("subtle",crypto)),Modernizr.addTest("fullscreen",!(!prefixed("exitFullscreen",document,!1)&&!prefixed("cancelFullScreen",document,!1))),Modernizr.addAsyncTest(function(){var e;try{e=prefixed("indexedDB",window)}catch(t){}if(e){var n="modernizr-"+Math.random(),r=e.open(n);r.onerror=function(){r.error&&"InvalidStateError"===r.error.name?addTest("indexeddb",!1):(addTest("indexeddb",!0),detectDeleteDatabase(e,n))},r.onsuccess=function(){addTest("indexeddb",!0),detectDeleteDatabase(e,n)}}else addTest("indexeddb",!1)}),Modernizr.addTest("intl",!!prefixed("Intl",window)),Modernizr.addTest("backgroundblendmode",prefixed("backgroundBlendMode","text")),Modernizr.addTest("objectfit",!!prefixed("objectFit"),{aliases:["object-fit"]}),Modernizr.addTest("regions",function(){if(isSVG)return!1;var e=prefixed("flowFrom"),t=prefixed("flowInto"),n=!1;if(!e||!t)return n;var r=createElement("iframe"),o=createElement("div"),i=createElement("div"),s=createElement("div"),d="modernizr_flow_for_regions_check";i.innerText="M",o.style.cssText="top: 150px; left: 150px; padding: 0px;",s.style.cssText="width: 50px; height: 50px; padding: 42px;",s.style[e]=d,o.appendChild(i),o.appendChild(s),docElement.appendChild(o);var a,l,c=i.getBoundingClientRect();return i.style[t]=d,a=i.getBoundingClientRect(),l=parseInt(a.left-c.left,10),docElement.removeChild(o),42==l?n=!0:(docElement.appendChild(r),c=r.getBoundingClientRect(),r.style[t]=d,a=r.getBoundingClientRect(),c.height>0&&c.height!==a.height&&0===a.height&&(n=!0)),i=s=o=r=undefined,n}),Modernizr.addTest("wrapflow",function(){var e=prefixed("wrapFlow");if(!e||isSVG)return!1;var t=e.replace(/([A-Z])/g,function(e,t){return"-"+t.toLowerCase()}).replace(/^ms-/,"-ms-"),n=createElement("div"),r=createElement("div"),o=createElement("span");r.style.cssText="position: absolute; left: 50px; width: 100px; height: 20px;"+t+":end;",o.innerText="X",n.appendChild(r),n.appendChild(o),docElement.appendChild(n);var i=o.offsetLeft;return docElement.removeChild(n),r=o=n=undefined,150==i}),testRunner(),setClasses(classes),delete ModernizrProto.addTest,delete ModernizrProto.addAsyncTest;for(var i=0;i<Modernizr._q.length;i++)Modernizr._q[i]();window.Modernizr=Modernizr}(window,document);
// source --> https://vizulab.com.au/wp-content/plugins/google-analyticator/external-tracking.min.js?ver=6.5.4 
jQuery(document).ready(function(){jQuery("a").each(function(){var e=jQuery(this);var t=e.attr("href");if(t==undefined||t=="")return;var n=t.replace("http://","").replace("https://","");var r=t.split(".").reverse();var i=r[0].toLowerCase();var r=t.split("/").reverse();var s=r[2];var o=false;if(typeof analyticsFileTypes!="undefined"){if(jQuery.inArray(i,analyticsFileTypes)!=-1){o=true;e.click(function(){if(analyticsEventTracking=="enabled"){if(analyticsSnippet=="enabled"){_gaq.push(["_trackEvent","Downloads",i.toUpperCase(),t])}else{ga("send","event","Downloads",i.toUpperCase(),t)}}else{if(analyticsSnippet=="enabled"){_gaq.push(["_trackPageview",analyticsDownloadsPrefix+n])}else{ga("send","pageview",analyticsDownloadsPrefix+n)}}})}}if(t.match(/^http/)&&!t.match(document.domain)&&o==false){e.click(function(){if(analyticsEventTracking=="enabled"){if(analyticsSnippet=="enabled"){_gaq.push(["_trackEvent","Outbound Traffic",t.match(/:\/\/(.[^/]+)/)[1],t])}else{ga("send","event","Outbound Traffic",t.match(/:\/\/(.[^/]+)/)[1],t)}}else if(analyticsSnippet=="enabled"){_gaq.push(["_trackPageview",analyticsOutboundPrefix+n])}else{ga("send","pageview",analyticsOutboundPrefix+n)}})}})});