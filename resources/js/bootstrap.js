window._ = require("lodash");

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require("popper.js").default;
    window.apiResponseStatus = {
        SUCCESS: "Success",
        FAILED: "Failed",
        ERROR: "Error"
    };
    window.appHelper = {
        currencyFormatter: new Intl.NumberFormat("en-PH", {
            style: "currency",
            currency: "PHP"
        }),
        convertSerializedArrayToOjbect(arr) {
            let return_object = {};
            arr.map(function(data) {
                return_object[data.name] = data.value;
            });
            return return_object;
        },
        sortObjectByValues(list) {
            return Object.keys(list).sort(function(a, b) {
                return list[a] - list[b];
            });
        },
        arrayToCsv(export_data, table_name) {
            if (export_data.length <= 0) {
                alert("Error -- No data recorded.");
                return true;
            }
            var csvData = new Blob([export_data.join("\r\n")], {
                type: "text/csv"
            });
            var csvUrl = URL.createObjectURL(csvData);
            var link = document.createElement("a");
            link.setAttribute("href", csvUrl);
            link.setAttribute("download", table_name + ".csv");
            document.body.appendChild(link);
            link.click();
        },
        ifItemExistInArray(arr, item) {
            let existed = false;
            let curr_index = arr.indexOf(item);
            if (curr_index > -1) {
                existed = true;
            }
            return existed;
        },
        removeItemFromArray(arr, item) {
            let curr_index = arr.indexOf(item);
            if (curr_index > -1) {
                arr.splice(curr_index, 1);
            }
            return arr;
        },
        removeItemsInArrayUsingArray(
            first_arr,
            second_arr,
            item_property = ""
        ) {
            first_arr.map(function(item) {
                let curr_index = second_arr.indexOf(item);
                if (item_property !== "") {
                    curr_index = second_arr.indexOf(item[item_property]);
                }
                if (curr_index > -1) {
                    second_arr.splice(curr_index, 1);
                }
            });
            return second_arr;
        },
        findDuplicates(arr) {
            let filtered_items = [];
            let duplicates = [];
            arr.map(function(item) {
                const curr_index = filtered_items.indexOf(item);
                if (curr_index > -1) {
                    duplicates.push(item);
                } else {
                    filtered_items.push(item);
                }
            });
            return duplicates;
        },
        hasDuplicateValuesInArray(arr) {
            let filtered_items = [];
            let hasDuplicate = false;
            arr.map(function(item) {
                const curr_index = filtered_items.indexOf(item);
                if (curr_index > -1) {
                    hasDuplicate = true;
                } else {
                    filtered_items.push(item);
                }
            });
            return hasDuplicate;
        }
    };
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require("axios");

window.axios.defaults.headers.common = {
    "X-Requested-With": "XMLHttpRequest",
    "Access-Control-Allow-Credentials": true,
    "X-CSRF-TOKEN": document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
    "X-XSRF-TOKEN": document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content")
};
axios.defaults.withCredentials = true;
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
