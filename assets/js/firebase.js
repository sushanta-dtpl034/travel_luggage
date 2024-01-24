console.log('Before initializeApp');
import { initializeApp } from "https://www.gstatic.com/firebasejs/9.4.0/firebase-app.js";
import { getAuth, signInWithPhoneNumber } from "https://www.gstatic.com/firebasejs/9.4.0/firebase-auth.js";
// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
	apiKey: "AIzaSyDk01Z4eRQVIfF8U64giotP-H__t-ow12I",
	authDomain: "fir-phone-auth-36037.firebaseapp.com",
	projectId: "fir-phone-auth-36037",
	storageBucket: "fir-phone-auth-36037.appspot.com",
	messagingSenderId: "229083022602",
	appId: "1:229083022602:web:d8d28bb367824d6a25e6f3",
	measurementId: "G-2VCBWY7778"
};

// Initialize Firebase
 const app = initializeApp(firebaseConfig);
 const auth = getAuth();


signInWithPhoneNumber(auth, phoneNumber)
    .then((confirmationResult) => {
        console.log(confirmationResult);
      // SMS sent. Prompt user to type the code from the message, then sign the
      // user in with confirmationResult.confirm(code).
      window.confirmationResult = confirmationResult;
      // ...
    }).catch((error) => {
      // Error; SMS not sent
      console.log('firebase sms error');
    });


    // Turn off phone auth app verification.
firebase.auth().settings.appVerificationDisabledForTesting = true;

var phoneNumber = "+919348504341";
var testVerificationCode = "123456";

// This will render a fake reCAPTCHA as appVerificationDisabledForTesting is true.
// This will resolve after rendering without app verification.
var appVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container');
// signInWithPhoneNumber will call appVerifier.verify() which will resolve with a fake
// reCAPTCHA response.
firebase.auth().signInWithPhoneNumber(phoneNumber, appVerifier)
    .then(function (confirmationResult) {
      // confirmationResult can resolve with the fictional testVerificationCode above.
      return confirmationResult.confirm(testVerificationCode)
    }).catch(function (error) {
      // Error; SMS not sent
      // ...
    });

    
console.log('After initializeApp');

// const analytics = getAnalytics(app);  console.log('Before initializeApp');

// const uiConfig = {
// 	signInSuccessUrl: 'http://localhost/travel_luggage/Dashboard/superadmin_dasboard',
// 	signInOptions: [
// 		firebase.auth.PhoneAuthProvider.PROVIDER_ID
// 	]
// };
// const ui = new firebaseui.auth.AuthUI(firebase.auth());
// ui.start('#firebaseui-auth-container', uiConfig);

