/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('datatables.net-bs4');

import Vue from 'vue'
window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});


jQuery("#users").ready(function () {
    let datatable = jQuery("#users").DataTable( {
        select: 'single'
    });

    //Datasheet button clicks/Modal
    datatable.on("select", function(e, dt, type, indexes) {
        alert(e + dt + type + indexes);
        /*
        let id          = $(this).data("id");
        let action      = $(this).data("action");
        let page        = ($(this).data("target") !== "datasheet") ? $(this).data("target") : "";
        let url         = ($(this).data("target") !== "note" && $(this).data("target") !== "datasheet") ? "/datasheet/" + id + "/" + page + "/" + action : 0;

        // Add & Update

        if (action !== "delete") {

            $.ajax({
                url: url,
                type: "GET",
                success: function( data ) {
                    $("#modal-content" ).html( data );
                    $(".modal-title").text(action.toUpperCase() + " " + page.toUpperCase());
                    $('#editdatasheet').modal({backdrop: 'static', keyboard: false}).draggable();
                },
                error: function (data) {

                    // 401: Unauthorized
                    if (data.status === "401") {
                        location.href = "/";
                        // All other error codes
                    } else {
                        alert("An error has occured.  See log for details.");
                        console.log('Error:', data);
                    }
                }
            });

            // Delete

        } else {

            let oldBGcolor = $(this).closest(".datasheet-item").css("background-color");
            $(this).closest(".datasheet-item").css("background-color", "red");

            // Have to do it this way because the coloring was ending up after the confirm() dialog in the asychronus jQuery stack because of h
            let deleteFunction = function() {

                if (!confirm("Are you sure you want to delete this " + $(this).data("target") + "?")) {
                    $(this).closest(".datasheet-item").css("background-color", oldBGcolor);
                    return false;
                }

                //Intentionally ask them twice if it's an entire datasheet
                if ($(this).data("target").toLowerCase() === "datasheet" && !confirm("You are about to delete the ENTIRE datasheet and all su")) {
                    return false;
                }

                $.ajax({
                    url: url,
                    type: 'delete',
                    context: $(this),
                    success: function(data) {
                        window.location = "/";
                    },
                    error: function (data) {

                        console.log(data);

                        if (data.status == "401") {
                            location.href = "/";
                        } else {
                            alert("An error has occured.  See log for details.");
                            console.log('Error:', data);
                        }
                    }
                });

            }

            setTimeout(deleteFunction.bind(this), 100);
        }
    */

    });

    //Modal fixer
    $('#editdatasheet').on('shown.bs.modal', function () {
        $('#myInput').focus();
    });

    $('#editdatasheet').on('hidden.bs.modal', function () {
        $("#modal-errors").addClass("hide");
        $(".modal-footer").unbind("click");
    });
});
