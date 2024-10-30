function autocomplete(inp) {
    //const inp = document.getElementById("moebel_kalkulator_input");

    /*the autocomplete function takes one argument, the text input element*/
    var currentFocus;

    /*execute a function when someone writes in the text field:*/
    inp.addEventListener("input", function(e) {
        var a, b, i, val = this.value;

        /*close any already open lists of autocompleted values*/
        closeAllLists();
        if (!val) { return false;}

        currentFocus = -1;
        /*create a DIV element that will contain the items (values):*/
        a = document.createElement("DIV");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");
        /*append the DIV element as a child of the autocomplete container:*/
        this.parentNode.appendChild(a);

        const userAction = async () => {
            const input = inp.value;
            const url = encodeURI('https://weitergeben.org/wp-json/wgorg/v2/furniture/get-cities/' + input);
            const response = await fetch(url);
            const cities = await response.json();

            /*for each item in the array...*/
            for (i = 0; i < cities.length; i++) {
                /*create a DIV element for each matching element:*/
                b = document.createElement("DIV");
                /*make the matching letters bold:*/
                b.innerHTML = "<strong>" + cities[i][0].substr(0, val.length) + "</strong>";
                b.innerHTML += cities[i][0].substr(val.length);
                /*insert a input field that will hold the current array item's value:*/
                b.innerHTML += "<input type='hidden' value='" + cities[i][0] + "'>";

                /*execute a function when someone clicks on the item value (DIV element):*/
                b.addEventListener("click", function(e) {
                    /*insert the value for the autocomplete text field:*/
                    inp.value = this.getElementsByTagName("input")[0].value;

                    /*close the list of autocompleted values,
                    (or any other open lists of autocompleted values:*/
                    closeAllLists();

                    if (inp.id == 'moebel_kalkulator_input') {
                        calculate_furniture();
                    }
                });
                a.appendChild(b);
            }
        }
        userAction.apply();
    });

    /*execute a function presses a key on the keyboard:*/
    inp.addEventListener("keydown", function(e) {
        var x = document.getElementById(this.id + "autocomplete-list");
        if (x) x = x.getElementsByTagName("div");
        if (e.keyCode == 40) {
            /*If the arrow DOWN key is pressed,
            increase the currentFocus variable:*/
            currentFocus++;
            /*and and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 38) { //up
            /*If the arrow UP key is pressed,
            decrease the currentFocus variable:*/
            currentFocus--;
            /*and and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 13) {
            if (currentFocus > -1) {
                /*and simulate a click on the "active" item:*/
                if (x) x[currentFocus].click();
            }

            closeAllLists();
            if (inp.id == 'moebel_kalkulator_input') {
                calculate_furniture();
            }
        }
    });

    function addActive(x) {
        /*a function to classify an item as "active":*/
        if (!x) return false;
        /*start by removing the "active" class on all items:*/
        removeActive(x);
        if (currentFocus >= x.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = (x.length - 1);
        /*add class "autocomplete-active":*/
        x[currentFocus].classList.add("autocomplete-active");
    }

    function removeActive(x) {
        /*a function to remove the "active" class from all autocomplete items:*/
        for (var i = 0; i < x.length; i++) {
            x[i].classList.remove("autocomplete-active");
        }
    }

    function closeAllLists(elmnt) {
        /*close all autocomplete lists in the document,
        except the one passed as an argument:*/
        var x = document.getElementsByClassName("autocomplete-items");
        for (var i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inp) {
                x[i].parentNode.removeChild(x[i]);
            }
        }
    }

    /*execute a function when someone clicks in the document:*/
    document.addEventListener("click", function (e) {
        closeAllLists(e.target);
    });
}


function calculate_furniture() {
	// When button is pressed call 'wegwerf_kalkulator.php and display it
    const userAction = async() => {
        const city = document.getElementById('moebel_kalkulator_input').value;
        const url = encodeURI('https://weitergeben.org/wp-json/wgorg/v2/furniture/calculate/' + city);
        const response = await fetch(url);
        const city_amount = await response.json();

        //document.getElementById("moebel_kalkulator_input").value = "";
        var elem_txt = document.getElementById("moebel_kalkulator_text");

        if (city_amount.length > 0) {
            console.log(link_allowed);
            const assessment = link_allowed ? '<a target="_blank" rel="noopener noreferrer" href="https://weitergeben.org/wo-landen-altmoebel">Einschätzung</a>' : 'Einschätzung';
            elem_txt.innerHTML = "Nach unserer " + assessment + " werden in <b>" + city + "</b> jede Woche etwa <b>" + city_amount[0] + "</b> Möbel weggeworfen!";
        } else {
            elem_txt.innerHTML = "Leider liegen uns zu der von ihnen angegebenen Stadt keine Daten vor.";
        }
    }
    userAction.apply();
}
