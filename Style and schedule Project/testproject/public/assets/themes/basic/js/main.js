
// hero_area_carousel
var $gallery = $('.hero_slider');
var slideCount = null;

$( document ).ready(function() {
     $gallery.slick({
       speed: 250,
       fade: true,
       cssEase: 'linear',
       swipe: true,
       swipeToSlide: true,
       touchThreshold: 10,
     });
 });

 $gallery.on('init', function(event, slick){
   slideCount = slick.slideCount;
   setSlideCount();
   setCurrentSlideNumber(slick.currentSlide);
 });

 $gallery.on('beforeChange', function(event, slick, currentSlide, nextSlide){
   setCurrentSlideNumber(nextSlide);
 });

 function setSlideCount() {
   var $el = $('.slide-count-wrap').find('.total');
   $el.text(slideCount);
 }

 function setCurrentSlideNumber(currentSlide) {
   var $el = $('.slide-count-wrap').find('.current');
   $el.text(currentSlide + 1);
 }



$(document).ready(function () {

  // service_area_carousel
  $('.service_area_carousel').owlCarousel({
    loop: true,
    autoplay: false,
    margin: 10,
    nav: true,
    dots: false,
    // rtl:true,
    responsive: {
      0: {
        items: 1
      },
      600: {
        items: 1
      },
      1000: {
        items: 2
      }
    }
  });
  // ourteam_area_carousel
  $('.ourteam_area_carousel').owlCarousel({
    loop: true,
    autoplay: false,
    margin: 30,
    nav: false,
    dots: true,
    // rtl:true,
    responsive: {
      0: {
        items: 1
      },
      400: {
        items: 2
      },
      768: {
        items: 3
      },
      992: {
        items: 4
      }
    }
  });

  // testimonial_area_start
  $('.testimonial_slider').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    fade: true,
    draggable: false,
    asNavFor: '.testimonial_thamnail'
  });
  $('.testimonial_thamnail').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    asNavFor: '.testimonial_slider',
    dots: false,
    centerMode: true,
    focusOnSelect: true,
    vertical: true
  });

  // single_product_area_start
  $('.single_product_slider').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: true,
    fade: true,
    draggable: false,
    asNavFor: '.single_product_thumbnail'
  });
  $('.single_product_thumbnail').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    asNavFor: '.single_product_slider',
    dots: false,
    centerMode: true,
    focusOnSelect: true,
    vertical: false
  });



});


// preloader_area
var preloader = document.getElementById("preloader");
function preloder_function(){
    preloader.style.display= "none";
}




$(document).ready(function () {

  //gallery_area_mixitup
  var mixer = mixitup('.cols');

  // gallery_magnificPopup
  $('.gallery_magnific_popup').magnificPopup({
    type: 'image',
    delegate: 'a',
    gallery: {
      enabled: true
    }

  });
  // footer_magnificPopup
  $('.footer_magnific_popup').magnificPopup({
    type: 'image',
    delegate: 'a',
    gallery: {
      enabled: true
    }

  });

  // main_services_counter
  $('.main_services_counter').counterUp({
    delay: 10,
    time: 1000
  });


  // faq_area_start
  $("button.accordion_title").on("click",function () {
    $(this).next().slideToggle();
    if (this.firstElementChild.classList.contains("fa-plus")) {
      this.firstElementChild.classList.replace("fa-plus", "fa-minus");
    } else {
      this.firstElementChild.classList.replace("fa-minus", "fa-plus");
    }
  });
});

$(document).ready(function(){
  // aos_animation
  AOS.init({
    offset: 120,
    duration: 1000,
  });


});


// Shopping Cart //
var shoppingCart = (function () {

    cart = [];

    // Constructor
    function Item(id, name, price, count, image, currency, quantity = null, attributes = null, attributesName = null) {
        this.id = id;
        this.name = name;
        this.price = price;
        this.count = count;
        this.image = image;
        this.currency = currency;
        this.quantity = quantity;
        this.attributes = attributes;
        this.attributesName = attributesName;
    }

    // Save cart
    function saveCart() {
        sessionStorage.setItem('shoppingCart', JSON.stringify(cart));
    }

    // Load cart
    function loadCart() {
        cart = JSON.parse(sessionStorage.getItem('shoppingCart'));
    }

    if (sessionStorage.getItem("shoppingCart") != null) {
        loadCart();
    }


    var obj = {};

    // Add to cart
    obj.addItemToCart = function (id, name, price, count, image = null, currency, quantity = null, attributes, attributesName= null) {
        var attempt = 0;
        for (var item in cart) {
            if (cart[item].name === name && JSON.stringify(cart[item].attributes) == JSON.stringify(attributes)) {
                if (quantity == null) {
                    cart[item].count++;
                    saveCart();
                    return;
                } else {
                    cart[item].count += parseInt(quantity);
                    saveCart();
                    return;
                }
            } else {
                var attempt = 0;
            }
        }


        if (attempt == 0 && quantity != null) {
            var item = new Item(id, name, price, count, image, currency, quantity, attributes, attributesName);
            var first = 1;
            for (var i = quantity; i > 0; i--) {
                if (first == 1) {
                    first = 0;
                    cart.push(item);
                    saveCart();
                } else {
                    shoppingCart.addItemToCart(id, name, price, 1, image, currency, null, attributes, attributesName);
                }
            }
        }

        if (quantity == null) {
            var item = new Item(id, name, price, count, image, currency, null, attributes, attributesName);
            cart.push(item);
            saveCart();
        }
    }
    // Set count from item
    obj.setCountForItem = function (name, count) {
        for (var i in cart) {
            if (cart[i].name === name) {
                cart[i].count = count;
                break;
            }
        }
    };
    // Remove item from cart
    obj.removeItemFromCart = function (name) {
        for (var item in cart) {
            if (cart[item].name === name) {
                cart[item].count--;
                if (cart[item].count === 0) {
                    cart.splice(item, 1);
                }
                break;
            }
        }
        saveCart();
    }

    // Remove all items from cart
    obj.removeItemFromCartAll = function (name) {
        for (var item in cart) {
            if (cart[item].name === name) {
                cart.splice(item, 1);
                break;
            }
        }
        saveCart();
    }

    // Clear cart
    obj.clearCart = function () {
        cart = [];
        saveCart();
    }

    // Count cart
    obj.totalCount = function () {
        var totalCount = 0;
        for (var item in cart) {
            totalCount += cart[item].count;
        }
        return totalCount;
    }

    // Total cart
    obj.totalCart = function () {
        var totalCart = 0;
        for (var item in cart) {
            totalCart += cart[item].price * cart[item].count;
            if (cart[item].count === 0) {
                totalCart = 0;
                break;
            }
        }

        var total = `${Number(totalCart.toFixed(2))}`;
        return total;

    }

    // List cart
    obj.listCart = function () {
        var cartCopy = [];
        for (i in cart) {
            item = cart[i];
            itemCopy = {};
            for (p in item) {
                itemCopy[p] = item[p];

            }
            itemCopy.total = Number(item.price * item.count).toFixed(2);
            cartCopy.push(itemCopy)
        }
        return cartCopy;
    }
    return obj;
})();


// Add item
$('.add-to-cart').on("click",function (event) {
    event.preventDefault();

    var id = $(this).data('id');
    var name = $(this).data('name');
    var price = Number($(this).data('price'));
    var image = $(this).data('image');
    var currency = $(this).data('currency');
    var quantity = $(this).data('quantity');
    var attributes = $(this).data('attributes');
    var route = $(this).data('route');


    var attributesName = null;

    $.ajax({
        url: route,
        method: "get",
        data: {
            productId: id,
            attributeIds: attributes,
        },
        success: function (response) {
            console.log(response.attributes);
            if (response.attributes){
                attributesName = JSON.stringify(response.attributes);
                shoppingCart.addItemToCart(id, name, price, 1, image, currency, quantity, attributes, attributesName);
                displayCart();
                Notiflix.Notify.Success("Added to Cart");
            }

            if(response.attributes == null){
                shoppingCart.addItemToCart(id, name, price, 1, image, currency, quantity, attributes);
                displayCart();
                Notiflix.Notify.Success("Added to Cart");
            }

        }
    });

});

// Clear items
$('.clear-cart').on('click', function () {
    shoppingCart.clearCart();
    displayCart();
});


function displayCart() {
    var cartArray = shoppingCart.listCart();
    var output = "";
    for (var i in cartArray) {

        var myString = cartArray[i].attributesName ?? '';
        let attributes = myString.replace(/[{}\"\[\]']+/g,'');
        let attributeName =  attributes.split(',').join(' ');

        output += `<li>
                       <a class="dropdown-item" href="javascript:void(0)">
                          <img src="${cartArray[i].image}" alt="" />
                          <div class="text">
                             <span>${cartArray[i].name}</span><br />
                             <span class="price">Price: ${cartArray[i].currency}${cartArray[i].price}</span> <br />
                             <span class="quantity">Qty: ${cartArray[i].count}</span><br>
                            <span class="attributesName">${attributeName}</span>
                             <button class="close delete-item" data-name="${cartArray[i].name}">
                                <i class="fal fa-times-circle"></i>
                             </button>
                          </div>
                       </a>
                    </li>`;
    }

    if (output.count === 0) {
        $('.total-count').html(0);
    } else {
        $('.total-count').html(shoppingCart.totalCount());
    }
    $('.show-cart').html(output);
    $('.total-cart').html(shoppingCart.totalCart());

}

// Delete item button
$('.show-cart').on("click", ".delete-item", function (event) {
    var name = $(this).data('name');
    shoppingCart.removeItemFromCartAll(name);
    displayCart();
    Notiflix.Notify.Success("Remove from Cart");
})


// -1
$('.show-cart').on("click", ".minus-item", function (event) {
    var name = $(this).data('name')
    shoppingCart.removeItemFromCart(name);
    displayCart();
})

// +1
$('.show-cart').on("click", ".plus-item", function (event) {
    var name = $(this).data('name')
    shoppingCart.addItemToCart(name);
    displayCart();
})

// Item count input
$('.show-cart').on("change", ".item-count", function (event) {
    var name = $(this).data('name');
    var count = Number($(this).val());
    shoppingCart.setCountForItem(name, count);
    displayCart();
});

displayCart();



















