<template>
    <div class='rating-stars text-center'>
        <ul id='stars'>
            <li class='star' data-value='1'>
                <i class='fa fa-star fa-fw'></i>
            </li>
            <li class='star' data-value='2'>
                <i class='fa fa-star fa-fw'></i>
            </li>
            <li class='star' data-value='3'>
                <i class='fa fa-star fa-fw'></i>
            </li>
            <li class='star' data-value='4'>
                <i class='fa fa-star fa-fw'></i>
            </li>
            <li class='star' data-value='5'>
                <i class='fa fa-star fa-fw'></i>
            </li>
            <li class='star' data-value='6'>
                <i class='fa fa-star fa-fw'></i>
            </li>
            <li class='star' data-value='7'>
                <i class='fa fa-star fa-fw'></i>
            </li>
            <li class='star' data-value='8'>
                <i class='fa fa-star fa-fw'></i>
            </li>
            <li class='star' data-value='9'>
                <i class='fa fa-star fa-fw'></i>
            </li>
            <li class='star' data-value='10'>
                <i class='fa fa-star fa-fw'></i>
            </li>
        </ul>
    </div>
</template>
<script>
export default {
    created(){
         $(document).on('mouseover','#stars li', function(){
            var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
        
            // Now highlight all the stars that's not after the current hovered star
            $(this).parent().children('li.star').each(function(e){
                if (e < onStar) {
                $(this).addClass('hover');
                }
                else {
                $(this).removeClass('hover');
                }
            });
            
        }).on('mouseout', function(){
            $(this).parent().children('li.star').each(function(e){
            $(this).removeClass('hover');
            });
        });
        
        
        /* 2. Action to perform on click */
        $(document).on('click', '#stars li', () => {
            var onStar = parseInt($(this).data('value'), 10); // The star currently selected
 
            var stars = $(this).parent().children('li.star');
            
            for (var i = 0; i < stars.length; i++) {
                $(stars[i]).removeClass('selected');
            }
            
            for (var i = 0; i < onStar; i++) {
                $(stars[i]).addClass('selected');
            }
            
            // JUST RESPONSE (Not needed)
            var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
            var msg = "";
            if (ratingValue > 1) {
                msg = "Thanks! You rated this " + ratingValue + " stars.";
            }
            else {
                msg = "We will improve ourselves. You rated this " + ratingValue + " stars.";
            }

            toastr.success(msg);
            
        });

    }
}
</script>
<style lang="scss" scoped>
    /* Rating Star Widgets Style */
    .rating-stars ul {
        list-style-type:none;
        padding:0;
        
        -moz-user-select:none;
        -webkit-user-select:none;
    }
    .rating-stars ul > li.star {
        display:inline-block;
    
    }

    /* Idle State of the stars */
    .rating-stars ul > li.star > i.fa {
        font-size:1.5em; /* Change the size of the stars */
        color:#ccc; /* Color on idle state */
    }

    /* Hover state of the stars */
    .rating-stars ul > li.star.hover > i.fa {
        color:#FFCC36;
    }

    /* Selected state of the stars */
    .rating-stars ul > li.star.selected > i.fa {
        color:#FF912C;
    }
</style>