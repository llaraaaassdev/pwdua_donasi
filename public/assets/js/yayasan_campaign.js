/* ======================================================
   Campaign Page Javascript
====================================================== */

document.addEventListener("DOMContentLoaded", function () {

    initializeSearch();
    initializeCardHover();
    initializeDeleteConfirmation();

});

/* ======================================================
   SEARCH CAMPAIGN
====================================================== */

function initializeSearch() {

    const input = document.getElementById("searchCampaign");

    if (!input) return;

    input.addEventListener("keyup", function () {

        let keyword = this.value.toLowerCase();

        let cards = document.querySelectorAll(".campaign-item");

        cards.forEach(function(card){

            let title = card.querySelector("h4").innerText.toLowerCase();

            if(title.indexOf(keyword) > -1){

                card.style.display = "";

            }else{

                card.style.display = "none";

            }

        });

    });

}

/* ======================================================
   HOVER EFFECT
====================================================== */

function initializeCardHover(){

    let cards = document.querySelectorAll(".campaign-card");

    cards.forEach(function(card){

        card.addEventListener("mouseenter",function(){

            this.style.transition=".35s";

        });

    });

}

/* ======================================================
   DELETE CONFIRMATION
====================================================== */

function initializeDeleteConfirmation(){

    let buttons=document.querySelectorAll(".btn-delete");

    buttons.forEach(function(btn){

        btn.addEventListener("click",function(e){

            e.preventDefault();

            let url=this.getAttribute("href");

            let result=confirm("Yakin ingin menghapus campaign ini ?");

            if(result){

                window.location.href=url;

            }

        });

    });

}

/* ======================================================
   FUTURE FEATURE
====================================================== */

// Filter Status
function filterCampaign(status){

}

// Sorting
function sortCampaign(type){

}

// Ajax Reload
function reloadCampaign(){

}

// Infinite Scroll
function infiniteScroll(){

}