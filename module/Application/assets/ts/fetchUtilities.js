"use strict";
exports.__esModule = true;
exports.Utilities = void 0;
var Utilities = (function () {
    function Utilities() {
    }
    Utilities.post = function (action, data) {
        var formData = new FormData();
        for (var _i = 0, _a = Object.entries(data); _i < _a.length; _i++) {
            var _b = _a[_i], key = _b[0], value = _b[1];
            formData.append(key, value);
        }
        return fetch(action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        }).then(function (response) { return response.json(); });
    };
    Utilities.get = function (action, data) {
        var urlParams = data ?
            '?' + new URLSearchParams(data) :
            '';
        return fetch(action + urlParams, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        }).then(function (response) { return response.json(); });
    };
    return Utilities;
}());
exports.Utilities = Utilities;
