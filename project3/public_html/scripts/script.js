/* 
//Fatima Mohammed
//CIS 1440
//Project 3
//Winter 2023 
 */

"use strict";

// The Cat API - api key
// live_9ltn2HOiPxIeC21KggOulWbW8y0uwT01IpNIknxFqgFjJJJxu4jvVvHwYK7YzX3w

// how to use it!!!
// Use it as the 'x-api-key' header when making any request to the API

// api
// meowfacts.herokuapp.com/

const facts = document.querySelector(".facts");
const btn = document.querySelector(".btn");
const progress = document.querySelector(".progress");
var clicks = 0;
const email = document.getElementById("email"); 
const fname = document.getElementById("fname"); 
const lname = document.getElementById("lname"); 


// add a progress bar
// nope nvm, its breaking my code
/*
let i = 0;
function progressBar() {
  if (i === 0) {
    i = 1;
    var elem = document.getElementById("myBar");
    var width = 10;
    var id = setInterval(frame, 10);
    function frame() {
      if (width >= 100) {
        clearInterval(id);
        i = 0;
      } else {
        width++;
        elem.style.width = width + "%";
        elem.innerHTML = width + "%";   
        elem.style.color = "grey";
      }
    }
  }
};
*/

// GET request as tested in Postman
const getFacts = async () => {
    const reponse = await fetch("https://meowfacts.herokuapp.com/");
    if (reponse.ok) {
        const result = await reponse.json();
        return result.data[0];
    }
};

// maybe add a time delay here
const showFacts = async () => {
    facts.textContent = "One moment, new fact is loading!";

    const content = await getFacts();
    // what if there is an issue with the connection or the API or a limit is reached
    // truthy falsy logic type of code here
    // don't use null or "" or straight declarations
    if (content) {
         
        function showAfterDelay(){
            facts.textContent = content;
        }; 
        setTimeout(showAfterDelay,2000);
        console.log("New Fact is Displayed!");
        
    }
    else {
        // if I refresh too many times or there is a connection problem
        setTimeout(showAfterDelay,2000);
        facts.textContent = "No Cat Facts Today! API Limit Reached!";
    }
};

function buttonClick(){

    btn.addEventListener("click", () => {
        showFacts();
        console.log("Fact Finding In Progress!");
    });
    
    clicks += 1;
    console.log("click tracking = "+clicks);
    progress.innerHTML = "Wow, you have learned "+clicks+" fact(s)!" ;

    showFacts();

};

function buttonTrivia(){
    console.log("Sign up button testing = yes!");

};






