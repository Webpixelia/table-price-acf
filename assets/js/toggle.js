'use strict';
// i18n support
const { __, _x, _n, _nx } = wp.i18n;
function planPeriod() {
	const checkboxPeriod = document.getElementById("checkboxPeriod");
	const price = document.getElementsByClassName('priceNb');
	const period = document.getElementsByClassName('period');
	const PeriodMultiplier = document.getElementById("PeriodMultiplier").value;
	Array.from(price).forEach((e) => {
		e.textContent = checkboxPeriod.checked == true ? e.textContent*PeriodMultiplier : e.textContent/PeriodMultiplier
	});
	Array.from(period).forEach((e) => {
		e.textContent = checkboxPeriod.checked == true ? toggle_js_vars.second_frequency : toggle_js_vars.main_frequency // main_frequency & second_frequency define in wpdocs_register_scripts() in fucnctions.php
	});
}
const checkboxCurrency = document.getElementById("checkboxCurrency");
const eur = document.getElementsByClassName('price-eur');
const otherCurrency = document.getElementsByClassName('price-currency');

if (checkboxCurrency) {
checkboxCurrency.addEventListener("click", () => {
	Array.from(otherCurrency).forEach((x) => {
		x.style.display = x.style.display === "block" ? "none" : "block"
	});
	Array.from(eur).forEach((y) => {
		y.style.display = y.style.display == "none" ? "block" : "none"
	});
})
};