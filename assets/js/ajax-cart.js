$(document).ready(function () {
  // To Load Cart table
  function loadProducts() {
    $.ajax({
      url: "product-crud/fetch-product.php",
      type: "POST",
      success: function (data) {
        if (data == 0) {
          $("#cart-section .container").html(
            `<div class="empty-cart">
                <img src='assets/images/empty-cart.png' alt='Empty Cart'>
                <div class="detail">
                    <h1>Your Bshop Cart is empty</h1>
                    <a href="./" class="btn">Shop Now</a>
                </div>
              </div>`
          );
        } else {
          $("#cart-section #db-products").html(data);
        }
      }
    });
  }
  loadProducts();

  // To load Cart Product count 
  function loadProductCount() {
    $.ajax({
      url: "product-crud/product-count.php",
      type: "POST",
      success: function (data) {
        $("#cart-product-count").html(data);
      }
    });
  }
  loadProductCount();

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
      changeQuantity(quantity, $(this).prev().data("pid"));
    }else{
      toast.querySelector('.msg').innerText = "Only " + value + " quantity in Stock.";
      toast.classList.add("show");
      setTimeout(() => {
        toast.classList.remove("show");
      }, 4000);
    }
  });

  // To change the quantity in db
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
        else {
          console.log("Not in Stock.");
        }
      },
    });
  }

  // To Delete Products
  $(document).on("click", ".delete-btn", function () {
    var pId = $(this).data("pid");

    popupBox.classList.toggle('slide-down');
    overlayRating.classList.toggle("show");
    document.body.classList.toggle("no-scroll");

    let noBtn = popupBox.querySelector("#no");
    let yesBtn = popupBox.querySelector("#yes");

    yesBtn.onclick=()=>{
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
      popupBox.classList.toggle('slide-down');
      overlayRating.classList.toggle("show");
      document.body.classList.toggle("no-scroll");
    }
    noBtn.onclick=()=>{
      popupBox.classList.toggle('slide-down');
      overlayRating.classList.toggle("show");
      document.body.classList.toggle("no-scroll");
    }


  });


});