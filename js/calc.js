function priceCalc() {

    var PRICE = 6.75;//variable to hold current value per bushel
    var bush = prompt("Enter quantity of wheat (in bushels):");//get number of bushels to calculated
    bush = parseFloat(bush);//returns bush as a floating point number
    var total = bush * PRICE;//final price calculation
    total = parseFloat(total);//returns total as a floating point number


    /*alert("Miles per gallon = " + mpg);*/
    document.getElementById("p1").innerHTML = (bush + " Bushels of Hard Red Winter Wheat at $" + PRICE + " a bushel will cost $" + total);

}
