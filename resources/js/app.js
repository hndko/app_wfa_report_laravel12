import "./bootstrap";

// Import jQuery (required for toastr)
import jQuery from "jquery";
window.$ = window.jQuery = jQuery;

// Import Toastr
import toastr from "toastr";
window.toastr = toastr;

// Toastr Configuration
toastr.options = {
    closeButton: true,
    progressBar: true,
    positionClass: "toast-top-right",
    timeOut: "3000",
    showEasing: "swing",
    hideEasing: "linear",
    showMethod: "fadeIn",
    hideMethod: "fadeOut",
};
