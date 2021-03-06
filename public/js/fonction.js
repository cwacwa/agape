/* Lexique */
var tailleEcran;
var tailleSlide;
var num_detail;
var nombre_photos;
var num_photo;
var height;
var width;
var ratio = 342 / 256;
			
var aImages = new Array();
var cImages = new Array();
var iPrev = -1;
var iRnd = -1;
		
aImages[0] = "images/fondhome.jpg";
aImages[1] = "images/fonddiscover.jpg";
			
/* /Lexique */
function init(){
    
    "use strict";
    height = ($('body').height())/3;
    width = height*ratio;
    $('#slide img').css({
        'height' : height
    });
    $('#slide img').css({
        'width' : width+1
        });
                                
    $('.borderBox').css({
        'height' : height
    });
    $('.borderBox').css({
        'width' : width
    });
                                
    $('#slide').css({
        'width' : width*7-5
        });
    tailleEcran = window.innerWidth;
    tailleSlide = $('#slide').width();
    
}
			
			
$(document).ready(function(){
    "use strict";
    init();
				
    $(window).resize(function(){
        init();
    });
								
    for(var i=0; i<aImages.length; i++){
        cImages[i] = new Image();
        cImages[i].src = aImages[i];
    }
				
				
    $("img#bg").load(function(){
        /* Fade in 1 seconds */
        $("img#bg").fadeTo(1000,1);

        /* fade out after 4 seconds*/
                                                
        setTimeout(function(){
            $("img#bg").fadeOut(500);

            /* next image after 1.5 seconds */
            setTimeout(LoadImages,1000);
        },4000);
                                                
    });

    /* Start 1s apr�s le chargement */
    setTimeout(LoadImages,1000);
								
    $.preLoadImages(
        [
        'images/photos/photo1_01.jpg',
        'images/photos/photo1_02.jpg',
        'images/photos/photo2_01.jpg',
        'images/photos/photo2_02.jpg',
        'images/photos/photo2_03.jpg',
        'images/photos/photo2_04.jpg',
        'images/photos/photo2_05.jpg',
        'images/photos/photo3_01.jpg',
        'images/photos/photo4_01.jpg',
        'images/photos/photo4_02.jpg',
        'images/photos/photo4_03.jpg',
        'images/photos/photo4_04.jpg'
        ], function(){}
        );
                                
    //move the image in pixel
    var moveW;
    var moveH;
	
    //zoom percentage, 1.2 =120%
    var zoom = 1.2;

    //On mouse over those thumbnail
    $('.borderBox').hover(function() {

        //Set the width and height according to the zoom percentage
        width = $('.borderBox').width() * zoom;
        height = $('.borderBox').height() * zoom;
                                        
        moveW = (width - $('.borderBox').width()) / 2;
        moveH = (height - $('.borderBox').height()) / 2;

        //Move and zoom the image
        $(this).find('img').stop(false,true).animate({
            'width':width, 
            'height':height, 
            'top':-moveH, 
            'left':-moveW
            }, {
            duration:200
        });
    },
    function() {
        //Reset the image
        $(this).find('img').stop(false,true).animate({
            'width':$('.borderBox').width()+2, 
            'height':$('.borderBox').height(), 
            'top':'0', 
            'left':'0'
        }, {
            duration:100
        });	
    });
});


$(".lienmenu").click(function(){
    "use strict";
    
    if ($(this).attr('id') != 'link-contact' ) {
        
        $(".lienmenu ul").slideToggle();
        if($('ul').hasClass('open') && $(this).next().hasClass('open') == false){
            $('.open').hide('slide');    
        }

        $('.open').removeClass('open');
        if($(this).next().css('display') == 'block'){
            $(this).next().addClass('open');
        }

        if($(this).next().hasClass('menusub') == false){
            var numonglet = parseInt($(this).attr('name'),10);
            var margin = numonglet * 50;
            $('#fancy').animate({
                'marginTop' : margin
            }, 'fast' , 'easeOutExpo');

            if($("#panel").css('marginLeft') === "20px"){
                $('#home').css({
                    'display' : 'block'
                });
                $(".panel").animate({
                    "marginLeft": "-102%"
                }, "slow");
            }
            $("#panel").animate({
                "marginLeft": "20px"
            }, "slow",
            function(){
                $('#home').css({
                    'display' : 'none'
                });
            });
        }
    }
});

$(".lienmenusub").click(function(){
   
    var idlien = $(this).attr('id');
    if ($(this).hasClass('lienmenu')) {
        var level = 0;
    } else {
        var level = 1;
    }
    
    if($(this).next().hasClass('menusub') == false){
        var numonglet = parseInt($(this).attr('name'),10);
        var margin = numonglet * 50;
        $('#fancy').animate({
            'marginTop' : margin
        }, 'fast' , 'easeOutExpo');

        if($("#panel").css('marginLeft') === "20px"){
            $('#home').css({
                'display' : 'block'
            });
            
            $("#panel").animate({
                "marginLeft": "-102%"
            }, "slow", function(){
                    // récupération du contenu en fonction de idlien (id de la catégorie visée)
                    setXmlContent(idlien, level);
                }
            );
        } else {
            // récupération du contenu en fonction de idlien (id de la catégorie visée)
            setXmlContent(idlien, level);
        }
        $("#panel").animate({
            "marginLeft": "20px"
        }, "slow",
        function(){
            $('#home').css({
                'display' : 'none'
            });
        });
    }
    
    $('.lienmenusub.selected').removeClass('selected');
    $(this).addClass('selected');
});

$("#link-mention").click(function(){
    "use strict";
    if($("#panel-mentions").css('marginLeft') !== "20px"){
        $('#home').css({
            'display' : 'block'
        });
        $(".panel").animate({
            "marginLeft": "-102%"
        }, "slow");
        $(".lienmenu").css({
            'background-color' : ''
        });
    }
    $("#panel-mentions").animate({
        "marginLeft": "20px"
    }, "slow",
    function(){
        $('#home').css({
            'display' : 'none'
        });
    });
    if($('li').hasClass('selected')){
        $('.selected').removeClass('selected');
    }
});

$("#link-contact").click(function(){
    "use strict";
    if($("#panel-contact").css('marginLeft') !== "20px"){
        $('#home').css({
            'display' : 'block'
        });
        $(".panel").animate({
            "marginLeft": "-102%"
        }, "slow");
        $(".lienmenu").css({
            'background-color' : ''
        });
        
    }
    $("#panel-contact").animate({
        "marginLeft": "20px"
    }, "slow",
    function(){
        $('#home').css({
            'display' : 'none'
        });
    });
    if($('li').hasClass('selected')){
        $('.selected').removeClass('selected');
    }
});

$("#link-home").click(function(){
    "use strict";
    $('#home').css({
        'display' : 'block'
    });
    $(".panel").animate({
        "marginLeft": "-102%"
    }, "slow");
    if($('li').hasClass('selected')){
        $('.selected').removeClass('selected');
        $('#fancy').hide();
    }
    if($('ul').hasClass('open')){
        $('.open').hide('slide');
    }
    $('.open').removeClass('open');
});

function envoyerMail(){
    "use strict";
    var Inom = $('#nom').val();
    var Imail = $('#mail').val();
    var Imessage = $('#message').val();
				
    $('#wait').css({
        'visibility' : 'visible'
    });
                                
    $.ajax({
        url: 'includes/traitement.php',
        type: 'POST',
        cache: false,
        data: {
            nom : Inom, 
            email : Imail, 
            message : Imessage
        },
        success: function( msg ) {
            if(msg === "true"){
                $('#wait').css({
                    'visibility' : 'hidden'
                });
                $('#confirmBox').fadeIn('slow');
            } else {
                $('#wait').css({
                    'visibility' : 'hidden'
                });
                $('#alertBox').fadeIn('slow');
            }
        }
    });
}

$('.lienmenu').click(function(){
    "use strict";
    
    // si la catégorie a des enfants, on sort
    if ($(this).hasClass('hasChildren') || $(this).hasClass('selected') ) {
        $('.selected').removeClass('selected');
        $(this).addClass('selected');
        return;
    } 
    
    var level = 0;
    var idlien = $(this).attr('id');
    setXmlContent(idlien, level);
    $('.selected').removeClass('selected');
    
    $(this).addClass('selected');
});
            
$('#navigation').hover(function(){
    "use strict";
    $('#fancy').show();
}, function(){
    "use strict";
    if($('li').hasClass('selected')){
        if($('#fancy:animated')){
            $('#fancy').stop();
        }
        var position = $('.selected').position();
        var margin = position.top - 119;
        $('#fancy').animate({
            'marginTop' : margin
        }, 'fast' , 'easeOutExpo');
    } else {
        $('#fancy').hide();
    }
});

$('.lienmenu').mouseover(function(){
    "use strict";
    if($('#fancy:animated')){
        $('#fancy').stop();
    }
    var position = $(this).position();
    var margin = position.top - 119;
    $('#fancy').animate({
        'marginTop' : margin
    }, 'fast' , 'easeOutExpo');
});
                        
$('.lienmenusub').mouseover(function(){
    "use strict";
    if($('#fancy:animated')){
        $('#fancy').stop();
    }
    var position = $(this).parent().position();
    var margin = position.top - 169;
    $('#fancy').animate({
        'marginTop' : margin
    }, 'fast' , 'easeOutExpo');
});
            
function fermerConfirm(){
    "use strict";
    $('#confirmBox').fadeOut('slow');
}

function fermerAlert(){
    "use strict";
    $('#alertBox').fadeOut('slow');
}
			
$('#slide img').click(function(){
    "use strict";
    num_detail = parseInt($(this).attr('name'),10);
    num_photo = 1;
    $('#prev').css({
        'visibility' : 'hidden'
    });
    $.ajax({
        url: "includes/base.xml",
        type: "GET",
        dataType: "xml",
        success: function(xml){
            parseXml(xml);
        }
    });
});

function setXmlContent(idcategorie, level)
{
    $.ajax({
        url: "includes/base.xml",
        type: "GET",
        dataType: "xml",
        success: function(xml){
           $('#slide').html(''); 
           $(xml).find('categorie-' + level).each(function(){
                // on récupère les produits et les photos de la catégorie
                if ($(this).attr('id') == idcategorie) {
                    // on récupère la premiere photo de chaque produit contenu dans cette catégorie
                    $(this).find('produit').each(function(){
                        var idProduit = $(this).find('id').text();
                        var nom = $(this).find('name').text();
                        var description = $(this).find('description').text();
                        var info = $(this).find('info').text();
                        var link = $(this).find('photos').find('photo').first().next().text();
                        var idImage = $(this).find('photos').find('photo').first().next().attr('id');
                        var next = $(this).find('photos').find('photo').first().next().next().is('photo');
                        
                        $(this).find('photo').each(function(){
                            $('<div class="borderBox">' +
                                '<img id="mini-image-' + idProduit + '" src="'+$(this).text()+'">'+
                            '</div>').appendTo($('#slide'));
                                                      
                           return false;
                        });
                        
                         // ajout d'un écouteur sur chaque image de produit
                         $('#mini-image-' + idProduit).click(function(){
                            
                            $('#nom_produit').html(nom);
                            $('#desc_produit').html(description);
                            $('#info_produit').html(info);
                            $('#image_detail').css({
                                'background-image' : 'url("'+link+'")'
                            });
                            $('#current_prod_id').val(idProduit);
                            $('#current_img_id').val(idImage);
                            
                            // test s'il y a d'autres photos 
                            if (next) {
                                $('#next').css({'visibility' : 'visible'});
                            } else {
                                $('#next').css({'visibility' : 'hidden'});
                            }
                             $('#prev').css({
                                'visibility' : 'hidden'
                            });
                            $('#detailNext').fadeIn();
                       });
                    });
                    $('<div class="clr"></div>').appendTo($('#slide'));
                    
                }
                
                init();

            });
        }
    });
}

$('#close').click(function(){
    "use strict";
    $('#detailNext').fadeOut();
});

$('#next').click(function(){
    $('#prev').css({
        'visibility' : 'visible'
    });
    // on parse le fichier XML,
    // on vérifie s'il y a une photo suivante
    id = $('#current_prod_id').val();
    $.ajax({
        url: "includes/base.xml",
        type: "GET",
        dataType: "xml",
        success: function(xml){
            $(xml).find('produit').each(function(){
                if ($(this).find('id').first().text() == id) {
                    //on est dans le bon produit
                    var idImage = $('#current_img_id').val();
                    $(this).find('photo').each(function(){
                        if ($(this).attr('id') == idImage) {
                            if ($(this).next().is('photo')) {
                                link = $(this).next().text();
                                $('#image_detail').fadeOut(200, function(){
                                    $('#image_detail').css({
                                        'background-image' : 'url("'+link+'")'
                                    });
                                });
                                $('#image_detail').fadeIn(200);
                                $('#current_img_id').val($(this).next().attr('id'));
                                // suppression du bouton next s'il n'y a pas d'autre image derrière
                                if (!$(this).next().next().is('photo')) {
                                   
                                   $('#next').css({
                                        'visibility' : 'hidden'
                                    });
                                }
                                return;
                            }
                        }
                    });
                }
            });
        }
    
    });
});

$('#prev').click(function(){
    $('#next').css({
        'visibility' : 'visible'
    });
    // on parse le fichier XML,
    // on vérifie s'il y a une photo suivante
    id = $('#current_prod_id').val();
    $.ajax({
        url: "includes/base.xml",
        type: "GET",
        dataType: "xml",
        success: function(xml){
            $(xml).find('produit').each(function(){
                if ($(this).find('id').first().text() == id) {
                    //on est dans le bon produit
                    var idImage = $('#current_img_id').val();
                    $(this).find('photo').each(function(){
                        if ($(this).attr('id') == idImage) {
                            if ($(this).prev().is('photo')) {
                                link = $(this).prev().text();
                                $('#image_detail').fadeOut(200, function(){
                                    $('#image_detail').css({
                                        'background-image' : 'url("'+link+'")'
                                    });
                                });
                                $('#image_detail').fadeIn(200);
                                $('#current_img_id').val($(this).prev().attr('id'));
                                // suppression du bouton next s'il n'y a pas d'autre image derrière
                                if (!$(this).prev().prev().prev().is('photo')) {
                                   
                                   $('#prev').css({
                                        'visibility' : 'hidden'
                                    });
                                }
                                return;
                            }
                        }
                    });
                }
            });
        }
    
    });
});


/* ------------------------------- Contr�les slide -----------------------------------------------*/

$('#arrow_left').click(function(){
    "use strict";
    if(parseInt($('#slide').css('marginLeft'),10) < 0 && $('#slide').is(':animated') === false && parseInt($('#slide').css('marginLeft'),10) <= -300){
        var margin = parseInt($('#slide').css('marginLeft'),10) + 300;
        $('#slide').animate({
            'marginLeft' : margin
        });
    } else if (parseInt($('#slide').css('marginLeft'),10) < 0 && $('#slide').is(':animated') === false && parseInt($('#slide').css('marginLeft'),10) > -300){
        $('#slide').animate({
            'marginLeft' : 0
        });
    }
});

$('#arrow_right').click(function(){
    "use strict";
    var margin;
    var marge = $('#slide img').width()*6 - (tailleEcran - 288);
    if(parseInt($('#slide').css('marginLeft'),10) >= -marge && $('#slide').is(':animated') === false && parseInt($('#slide').css('marginLeft'),10) + marge > 300) {
        margin = parseInt($('#slide').css('marginLeft'),10) - 300;
        $('#slide').animate({
            'marginLeft' : margin
        });
    } else if(parseInt($('#slide').css('marginLeft'),10) >= -marge && $('#slide').is(':animated') === false && parseInt($('#slide').css('marginLeft'),10) + marge < 300){
        margin = parseInt($('#slide').css('marginLeft'),10) - (parseInt($('#slide').css('marginLeft'),10) + marge);
        $('#slide').animate({
            'marginLeft' : margin
        });
    }
});

/* ------------------------------- Background d�filant -------------------------------------- */


function LoadImage(iNr)
{
    "use strict";
			
    /* Nouveau background � l'image*/
    $("img#bg").attr("src", cImages[iNr].src);

}
			
function LoadImages()
{
    "use strict";
				
    /* On choisit une image al�atoirement */
    while(iPrev === iRnd)
    {
        iRnd = Math.floor(Math.random()*aImages.length);
    }
				
    /* On affiche l'image */
    LoadImage(iRnd);
				
    iPrev = iRnd;
				
}