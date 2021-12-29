$(function () {
    skinChanger();
    activateNotificationAndTasksScroll();

    setSkinListHeightAndScroll();
    setSettingListHeightAndScroll();
    $(window).resize(function () {
        setSkinListHeightAndScroll();
        setSettingListHeightAndScroll();
    });
});

//Skin changer
function skinChanger() {
    $('.right-sidebar .demo-choose-skin li').on('click', function () {
        var $body = $('body');
        var $this = $(this);

        var existTheme = $('.right-sidebar .demo-choose-skin li.active').data('theme');
        $('.right-sidebar .demo-choose-skin li').removeClass('active');
        $body.removeClass('theme-' + existTheme);
        $this.addClass('active');

        $body.addClass('theme-' + $this.data('theme'));
    });
}

//Skin tab content set height and show scroll
function setSkinListHeightAndScroll() {
    var height = $(window).height() - ($('.navbar').innerHeight() + $('.right-sidebar .nav-tabs').outerHeight());
    var $el = $('.demo-choose-skin');

    $el.slimScroll({ destroy: true }).height('auto');
    $el.parent().find('.slimScrollBar, .slimScrollRail').remove();

    $el.slimscroll({
        height: height + 'px',
        color: 'rgba(0,0,0,0.5)',
        size: '4px',
        alwaysVisible: false,
        borderRadius: '0',
        railBorderRadius: '0'
    });
}

//Setting tab content set height and show scroll
function setSettingListHeightAndScroll() {
    var height = $(window).height() - ($('.navbar').innerHeight() + $('.right-sidebar .nav-tabs').outerHeight());
    var $el = $('.right-sidebar .demo-settings');

    $el.slimScroll({ destroy: true }).height('auto');
    $el.parent().find('.slimScrollBar, .slimScrollRail').remove();

    $el.slimscroll({
        height: height + 'px',
        color: 'rgba(0,0,0,0.5)',
        size: '4px',
        alwaysVisible: false,
        borderRadius: '0',
        railBorderRadius: '0'
    });
}

//Activate notification and task dropdown on top right menu
function activateNotificationAndTasksScroll() {
    $('.navbar-right .dropdown-menu .body .menu').slimscroll({
        height: '254px',
        color: 'rgba(0,0,0,0.5)',
        size: '4px',
        alwaysVisible: false,
        borderRadius: '0',
        railBorderRadius: '0'
    });
}

$(document).on('click', '.reset_order', function(e) {
    e.preventDefault();
    var itemPrice= $(this).parent().parent().find('.total_price').val();
    var itemPr = parseInt(itemPrice);
    orderupdate(itemPr, 'remove');
    $(this).parent().parent().find('.item_total').html('$0.00');
    $(this).parent().parent().find('.total_price').val('0');
    $(this).parent().parent().find('.add_order').show();
    $(this).parent().parent().find('.reset_order').hide();
    $(this).parent().parent().find('.sqty').val('');
    $(this).parent().parent().find('.total_qty').val('');
    $(this).parent().parent().find('.sqty').attr('disabled', false);
});

$(document).on('click', '.reset_addon_order', function(e) {
    e.preventDefault();
    var itemPrice= $(this).parent().parent().find('.base_price').val();
    var itemPr =  parseInt(itemPrice);
    orderupdate(itemPr, 'remove');
    $(this).parent().parent().find('.item_total').html('$0.00'); 
    $(this).parent().parent().find('.base_price').val('');
    $(this).parent().parent().find('.add_addon_order').show();
    $(this).parent().parent().find('.reset_addon_order').hide();
    $(this).parent().parent().find('.total_qty').val('');
    $(this).parent().parent().find('.time_duration').val('');
    $(this).parent().parent().find('select.addon_dd').attr('disabled', false);
    $(this).parent().parent().find('.btn').removeClass('disabled');
    $(this).parent().parent().find('.btn-group').removeClass('disabled');
    
});

$(document).on('click', '.reset_bar_order', function(e) {
    e.preventDefault(); 
    var dd_val = $(this).parent().parent().find('.bartenderTime input[type="radio"]:checked').val();
    var itemPrice = $(this).parent().parent().find('.total_price').val();
    if (dd_val === 'bartendhalf'){ 
        var bartenderPrice = $('.bartenderhalf').val(); 
    } else{ 
        var bartenderPrice = $('.bartenderfull').val(); 
    }
    if($('.added_bar').length === 1){
         $('.bartenderTime input').attr('disabled',false);
    }
    $(this).parent().parent().find('.item_total').html('$0.00');
    $(this).parent().parent().find('.sqty').attr('disabled', false);
    $(this).parent().parent().find('.total_price').val('');
    $(this).parent().parent().find('.base_price').val('');
    $(this).parent().parent().find('.add_bar_order').show();
    $(this).parent().parent().find('.reset_bar_order').hide();
    $(this).parent().parent().find('.reset_bar_order').removeClass('added_bar');
    $(this).parent().parent().find('.total_qty').val('');
    $(this).parent().parent().find('.time_duration').val('');
    $(this).parent().parent().find('.sqty').val('');
    $(this).parent().parent().find('.total_qty').val('');
    var b_guests =0;
    var bartender_qty =0;
    var bartenderqty = 0;
    setTimeout( function(){
        $('.barmain .total_qty').each(function(){
            if($(this).val() !=''){
                b_guests += parseInt($(this).val());
            } 
        }) 
        if (b_guests > 0){

            if(b_guests > 50 && b_guests < 101 ){
                bartender_qty = 2+' Bartenders';
                bartenderqty = 2;

            } else if(b_guests > 100  ){
                bartender_qty = 3+' Bartenders';
                bartenderqty = 3;
            } else{
                bartender_qty = 1+' Bartender';
                bartenderqty = 1;
            } 

            var bartenderFee = bartenderqty*bartenderPrice;
            var bartenderQty = bartenderqty;
            var bartenderTime = dd_val;

            $('.bartender_fee').val(bartenderFee);
            $('.bartender_qty').val(bartenderQty);
            $('.bartender_time').val(bartenderTime);
        } else{
            $('.bartender_fee').val('0');
            $('.bartender_qty').val('0');
            $('.bartender_time').val('');
            
        }
        var itemPr = parseInt(itemPrice);  
        orderupdate(itemPr, 'remove');
   },200); 
    
});

$(document).on('click', '.add_order', function(e) {
    e.preventDefault();
    var itemPrice = $(this).parent().parent().find('.base_price').val();
    var itemQty = $(this).parent().parent().find('.sqty').val();
    if( ( itemPrice != '' && itemPrice.match(/^\d+$/)) || ( itemQty != '' && itemQty.match(/^\d+$/)) ) {
        if( itemQty >  0){
            var itemPr = parseInt(itemQty * itemPrice);
            orderupdate(itemPr, 'add');
            
            $(this).parent().parent().find('.item_total').html('$'+itemQty * itemPrice);
            $(this).parent().parent().find('.total_price').val(itemQty * itemPrice);
            $(this).parent().parent().find('.add_order').hide();
            $(this).parent().parent().find('.reset_order').show();
            $(this).parent().parent().find('.sqty').attr('disabled', true);
            $(this).parent().parent().find('.total_qty').val(itemQty);
        } else{
            alert('Please enter value greater than > 0');
            $(this).parent().parent().find('.item_total').html('$0.00');
            $(this).parent().parent().find('.total_price').val('0');
        }
    } else{
        alert('Please enter valid numbers');
        $(this).parent().parent().find('.item_total').html('$0.00');
        $(this).parent().parent().find('.total_price').val('0');
    }
});

$(document).on('click', '.add_addon_order', function(e) {
    e.preventDefault();
    var dd_val = $(this).parent().parent().find('select.addon_dd option:selected').val();
 
    if (dd_val === 'half'){
        var itemPrice = $(this).parent().parent().find('.addon_half').val();
        var time_duration = 'Half';
    } else{
        var itemPrice = $(this).parent().parent().find('.addon_full').val();
        var time_duration = 'Full';
    }

    if( dd_val != '' ) {
        var itemPr = parseInt(itemPrice);
        orderupdate(itemPr, 'add');
        $(this).parent().parent().find('.item_total').html('$'+itemPrice);
        $(this).parent().parent().find('.base_price').val(itemPrice);
        $(this).parent().parent().find('.add_addon_order').hide();
        $(this).parent().parent().find('.reset_addon_order').show();
        $(this).parent().parent().find('select').attr('disabled', true);
        $(this).parent().parent().find('.total_qty').val(dd_val);
        $(this).parent().parent().find('.time_duration').val(time_duration);

    } else {
        alert('Please select addons time duration');
        $(this).parent().parent().find('.item_total').html('$0.00');
        $(this).parent().parent().find('.base_price').val('0');
        $(this).parent().parent().find('.total_qty').val('');
        $(this).parent().parent().find('.time_duration').val('');
    }
});

$(document).on('click', '.add_bar_order', function(e) {
    e.preventDefault();
    var dd_val = $('.bartenderTime input[type="radio"]:checked').val();
    var itemQty = $(this).parent().parent().find('.sqty').val();
 
    if (dd_val === 'bartendhalf'){
        var itemPrice = $(this).parent().parent().find('.hprice').val(); 
        var basePrice = $(this).parent().parent().find('.hprice').val();
        var bartenderPrice = $('.bartenderhalf').val();
        var time_duration = 'Half';
    } else{
        var itemPrice = $(this).parent().parent().find('.fprice').val();
        var basePrice = $(this).parent().parent().find('.fprice').val();
        var bartenderPrice = $('.bartenderfull').val();
        var time_duration = 'Full';
    }

    if( ( itemPrice != '' && itemPrice.match(/^\d+$/)) || ( itemQty != '' && itemQty.match(/^\d+$/)) ) {
        if( itemQty >  0){
            itemPrice = itemPrice * itemQty;          
            $(this).parent().parent().find('.item_total').html('$'+itemPrice);
            $(this).parent().parent().find('.base_price').val(basePrice);
            $(this).parent().parent().find('.total_price').val(itemPrice);
            $(this).parent().parent().find('.add_bar_order').hide();
            $('.bartenderTime input').attr('disabled',true);
            $(this).parent().parent().find('.reset_bar_order').show();
            $(this).parent().parent().find('.reset_bar_order').addClass('added_bar');
            $(this).parent().parent().find('.sqty').attr('disabled', true);
            $(this).parent().parent().find('.total_qty').val(itemQty);
            $(this).parent().parent().find('.time_duration').val(time_duration);
            var b_guests =0;
            var bartender_qty =0;
            var bartenderqty = 0;
            setTimeout( function(){
                $('.barmain .total_qty').each(function(){
                    if($(this).val() !=''){
                        b_guests += parseInt($(this).val());
                    } 
                }) 

                if(b_guests > 50 && b_guests < 101 ){
                    bartender_qty = 2+' Bartenders';
                    bartenderqty = 2;

                } else if(b_guests > 100  ){
                    bartender_qty = 3+' Bartenders';
                    bartenderqty = 3;
                } else{
                    bartender_qty = 1+' Bartender';
                    bartenderqty = 1;
                } 

                var bartenderFee = bartenderqty*bartenderPrice;
                var bartenderQty = bartenderqty;
                var bartenderTime = dd_val;

                $('.bartender_fee').val(bartenderFee);
                $('.bartender_qty').val(bartenderQty);
                $('.bartender_time').val(bartenderTime);
                var itemPr = parseInt(bartenderFee)+ parseInt(itemPrice);
                orderupdate(itemPr, 'add');
           },200); 
            
        } else{
            alert('Please enter value greater than > 0');
            $(this).parent().parent().find('.item_total').html('$0.00');
            $(this).parent().parent().find('.base_price').val('');
            $(this).parent().parent().find('.total_qty').val('');
            $(this).parent().parent().find('.total_price').val('');
            $(this).parent().parent().find('.time_duration').val('');
            $(this).parent().parent().find('.sqty').attr('disabled', false);
        }
    } else{
        alert('Please enter valid numbers');
        $(this).parent().parent().find('.item_total').html('$0.00');
        $(this).parent().parent().find('.base_price').val('');
        $(this).parent().parent().find('.total_qty').val('');
        $(this).parent().parent().find('.total_price').val('');
        $(this).parent().parent().find('.time_duration').val('');
        $(this).parent().parent().find('.sqty').attr('disabled', false);
    } 
});

function orderupdate(itemPr, action){
    var itemPr = itemPr;
    var action = action;
    var orderstotal = parseFloat($('.orderstotal').val());
    if (action == 'remove'){
        $('.orderstotal').val(orderstotal - itemPr);
    } else{
        $('.orderstotal').val(orderstotal + itemPr);   
    } 
    
    orderstotal = parseFloat($('.orderstotal').val());             
    var orderdiscount = parseFloat($('.orderdiscount').val()); 
    var ordertotal = parseFloat($('.ordertotal').val()); 
    var defaulttax = parseFloat($('.defaulttax').val());
    var ordertax = ((defaulttax / 100) * orderstotal).toFixed(2);
    $('.ordertax').val(parseFloat(ordertax));
    $('.ordertotal').val(orderstotal + orderdiscount + parseFloat(ordertax));
     ordertotal = parseFloat($('.ordertotal').val()); 
     
    var orderdue = $('.orderdue').val();
    var orderadvance = $('.orderadvance').val();
    $('.orderdue').val(( $('.ordertotal').val() - $('.orderadvance').val()).toFixed(2));
    
    ordertax = $('.ordertax').val();
    orderdue = $('.orderdue').val();
    $('.osub').html('$'+orderstotal);
    $('.otax').html('$'+ordertax);
    $('.ototal').html('$'+ordertotal);
    $('.odue').html('$'+orderdue);

}