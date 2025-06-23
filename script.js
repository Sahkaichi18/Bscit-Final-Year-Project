// Login page (Ctrl Z.......for Og case!)

const signUpButton=document.getElementById('signUpButton');
const signInButton=document.getElementById('signInButton');
const signInForm=document.getElementById('signIn');
const signUpForm=document.getElementById('signup');

signUpButton.addEventListener('click',function(){
    signInForm.style.display="none";
    signUpForm.style.display="block";
})
signInButton.addEventListener('click', function(){
    signInForm.style.display="block";
    signUpForm.style.display="none";
})



// Home page


// Subscription 

document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("subscribeBtn").addEventListener("click", function () {
        let email = document.getElementById("emailInput").value;

        if (!email) {
            alert("Please enter a valid email!");
            return;
        }

        fetch("subscribe.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "email=" + encodeURIComponent(email)
        })
        .then(response => response.json())
        .then(data => {
            let message = document.getElementById("subscribeMessage");
            message.style.display = "block";
            message.style.color = data.status === "success" ? "green" : "red";
            message.innerText = data.message;
            
            if (data.status === "success") {
                document.getElementById("emailInput").value = "";
            }
        })
        .catch(error => console.error("Error:", error));
    });
});



// Checkout page

document.addEventListener("DOMContentLoaded", function() {
    const orderBtn = document.querySelector(".checkout-btn");
    if (orderBtn) {
        orderBtn.addEventListener("click", function(event) {
            event.preventDefault();
            document.querySelector(".checkout-order-message-container").style.display = "flex";
        });
    }
});

