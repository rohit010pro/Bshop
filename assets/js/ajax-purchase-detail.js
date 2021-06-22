const toast = document.querySelector(".toast");
const closeBtn = document.querySelector(".close");
closeBtn.addEventListener("click", () => {
    toast.classList.remove("show");
});


$(document).ready(function () {
  var urlString = window.location.href;
  var url = new URL(urlString);

  // If Redirect From Cart Page
  if (url.searchParams.get("fromcartpage") == "true") {
    // To Load Cart table
    function loadProducts() {
      $.ajax({
        url: "product-crud/fetch-product.php",
        type: "POST",
        success: function (data) {
          if (data == 0) {
            $("#purchase-detail .container").html(`<h1>No Product Found</h1>`);
          } else {
            $("#purchase-detail #db-products").html(data);
          }
        }
      });
    }
    loadProducts();

    //To Decrement the value of Input box
    $(document).on("click", ".quantity-wrapper .minus", function () {
      let value = +$(this).next().val();
      let minValue = +$(this).next().attr("min");

      if (value > minValue) {
        let quantity = value - 1;
        $(this).next().val(quantity);
        changeQuantity(quantity, $(this).next().data("pid"));
      }
    });

    //To Increment the value of Input box
    $(document).on("click", ".quantity-wrapper .plus", function () {
      let value = +$(this).prev().val();
      let maxValue = +$(this).prev().attr("max");

      if (value < maxValue) {
        let quantity = value + 1;
        $(this).prev().val(quantity);
        changeQuantity(quantity, $(this).prev().data("pid"));
      }
    });

  
    // To change the quantity in Database
    function changeQuantity(qty, pId) {
      $.ajax({
        url: "product-crud/edit-quantity.php",
        type: "POST",
        data: {
          product_Id: pId,
          quantity: qty,
        },
        success: function (data) {
          if (data == 1) loadProducts();
          else console.log("Failed");
        },
      });
    }

    // To Delete Products
    $(document).on("click", ".delete-btn", function () {
      var pId = $(this).data("pid");

      $.ajax({
        url: "product-crud/delete-product.php",
        type: "POST",
        data: {
          product_Id: pId,
        },
        success: function (data) {
          if (data == 1) {
            loadProducts();
            loadProductCount();
          } else {
            console.log("Failed");
          }
        },
      });
    });

  }
  // If Redirect From Product Detail Page
  else if (url.searchParams.get("productId") != "") {
    // To Decrement the value of Input box
    $(document).on("click", ".quantity-wrapper .minus", function () {
      let value = +$(this).next().val();
      let minValue = +$(this).next().attr("min");
      
      if (value > minValue) {
        let quantity = value - 1;
        $(this).next().val(quantity);
        let netPrice = +$(".product-details .net-price .pv").html();
        $('.product .sub-total .p').html(netPrice * quantity);
        $('#products-total .price .p span').html(netPrice * quantity);
        $('#products-total .total p span').html(netPrice * quantity);
      }
    });

    // To Increment the value of Input box
    $(document).on("click", ".quantity-wrapper .plus", function () {
      let value = +$(this).prev().val();
      let maxValue = +$(this).prev().attr("max");

      if(value == 10){
        toast.querySelector('.msg').innerText = "You can buy only 10 Quantity";
        toast.classList.add("show");
        setTimeout(() => {
          toast.classList.remove("show");
        }, 4000);
      } 
      else if (value < maxValue) {
        let quantity = value + 1;
        $(this).prev().val(quantity);
        let netPrice = +$(".product-details .net-price .pv").html();
        $('.product .sub-total .p').html(netPrice * quantity);
        $('#products-total .price .p span').html(netPrice * quantity);
        $('#products-total .total p span').html(netPrice * quantity);
      }else{
        toast.querySelector('.msg').innerText = "Only " + value + " quantity in Stock.";
        toast.classList.add("show");
        setTimeout(() => {
          toast.classList.remove("show");
        }, 4000);
      }
    });
  }

});