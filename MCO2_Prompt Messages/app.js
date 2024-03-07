const confirmOrderPrompt = document.getElementById('confirm-order-prompt');
const confirmOrderButton = confirmOrderPrompt.querySelector('#confirm-order');

const paymentPrompt = document.getElementById('payment-prompt');
const paymentOptions = paymentPrompt.querySelector('.options');
const creditCardButton = paymentOptions.querySelector('#credit-card');
const gcashButton = paymentOptions.querySelector('#gcash');
const cashButton = paymentOptions.querySelector('#cash');

const creditCardPrompt = document.getElementById('credit-card-prompt');
const creditCardNumberInput = creditCardPrompt.querySelector('#card-number');
const expirationDateInput = creditCardPrompt.querySelector('#expiration-date');
const cvvInput = creditCardPrompt.querySelector('#cvv');
const submitCreditCardButton = creditCardPrompt.querySelector('#submit-credit-card');

const cashPrompt = document.getElementById('cash-prompt');
const totalPayment = cashPrompt.querySelector('#total-payment');
const change = cashPrompt.querySelector('#change');
const submitCashButton = cashPrompt.querySelector('#submit-cash');

const gcashPrompt = document.getElementById('gcash-prompt');
const submitGcashButton = gcashPrompt.querySelector('#submit-gcash');

const paymentFailedPrompt = document.getElementById('payment-failed-prompt');
const tryAgainButton = paymentFailedPrompt.querySelector('#try-again');
const chooseAnotherButton = paymentFailedPrompt.querySelector('#choose-another');

const paymentSuccessfulPrompt = document.getElementById('payment-successful-prompt');
const orderNumber = paymentSuccessfulPrompt.querySelector('.order-number');

const loginPrompt = document.getElementById('login-prompt');
const loginForm = loginPrompt.querySelector('form');
const usernameInput = loginForm.querySelector('#username');
const passwordInput = loginForm.querySelector('#password');

confirmOrderButton.addEventListener('click', () => {
	// Handle confirm order
	paymentPrompt.style.display = 'block';
	confirmOrderPrompt.style.display = 'none';
});

creditCardButton.addEventListener('click', () => {
	// Handle credit card payment
	creditCardPrompt.style.display = 'block';
	paymentPrompt.style.display = 'none';
});

gcashButton.addEventListener('click', () => {
	// Handle GCash payment
    gcashPrompt.style.display = 'block';
	paymentPrompt.style.display = 'none';
});

cashButton.addEventListener('click', () => {
	// Handle cash payment
	cashPrompt.style.display = 'block';
	paymentPrompt.style.display = 'none';
	
	// Set total payment and change based on the order
	totalPayment.textContent = 'PHP 500.00';
	change.textContent = 'PHP 250.00';
});

submitCreditCardButton.addEventListener('click', () => {
	// Validate credit card information
	if (creditCardNumberInput.value === '' || expirationDateInput.value === '' || cvvInput.value === '') {
		alert('Please fill out all required fields.');
		return;
	}

	// Handle credit card submission
	// ...

	// Hide credit card prompt and show payment successful prompt
	creditCardPrompt.style.display = 'none';
	paymentSuccessfulPrompt.style.display = 'block';
	orderNumber.textContent = 'ORDER #0001';
});

submitCashButton.addEventListener('click', () => {
	// Handle cash submission
	// ...

	// Hide cash prompt and show payment successful prompt
	cashPrompt.style.display = 'none';
	paymentSuccessfulPrompt.style.display = 'block';
	orderNumber.textContent = 'ORDER #0001';
});

submitGcashButton.addEventListener('click', () => {
	// Handle GCash submission
	// ...

	// Hide GCash prompt and show payment successful prompt
	gcashPrompt.style.display = 'none';
	paymentSuccessfulPrompt.style.display = 'block';
	orderNumber.textContent = 'ORDER #0001';
});

tryAgainButton.addEventListener('click', () => {
	// Handle try again button
	paymentFailedPrompt.style.display = 'none';
	paymentPrompt.style.display = 'block';
});

chooseAnotherButton.addEventListener('click', () => {
	// Handle choose another button
	paymentFailedPrompt.style.display = 'none';
	loginPrompt.style.display = 'block';
});

loginForm.addEventListener('submit', (event) => {
	// Prevent default form submission behavior
	event.preventDefault();

	// Handle login form submission
	// ...

	// Hide login prompt and show payment prompt
	loginPrompt.style.display = 'none';
	paymentPrompt.style.display = 'block';
});