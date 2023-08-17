/* ---- Jquery ----- */
import $ from 'jquery';
global.jQuery = $;
global.$ = $;
window.jQuery = $;
window.$ = $;
/* ---- Jquery ----- */
/* ---- Bootstrap ----- */
import "bootstrap/dist/js/bootstrap.min.js";
import "bootstrap/dist/css/bootstrap.min.css";
/* ---- Bootstrap ----- */ 

/* ---- Styles ----- */ 
import "./styles.scss"
/* ---- Styles ----- */ 

/* ---- utilities ----- */ 
require('utilities/utilities.js')
/* ---- utilities ----- */ 

var { main } = require("./main.js");

$(function() {
    main() ;
})