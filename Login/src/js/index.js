var $anime = $('.anime'),
        animationClass = 'anime-start',
        offset = $(window).height() * 4/4;

    function animeScroll(){
        var documentTop = $(document).scrollTop();

        $anime.each(function(){
            var itemTop = $(this).offset().top;

            if(documentTop > itemTop - offset){
                $(this).addClass(animationClass);
            } else {
                $(this).removeClass(animationClass);
            }
        });
    }

// var $input1 = $('#input1'),
//     $input2 = $('#input2'),
//     formActiveClass = 'form-active';

// $('#input1').load(function(){
//         $('input').animate({"border-bottom": "2.5px solid #087E8B",
//             "transform": "scaleX(1)"},slow);
//     });

    // function input2Active(){
    //     if($input2.focus){
    //         $($input2).addClass(formActiveClass);
    //     } else{
    //         $($input2).removeClass(formActiveClass);
    //     }
    // }