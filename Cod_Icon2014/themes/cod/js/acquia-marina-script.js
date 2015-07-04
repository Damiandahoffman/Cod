// $Id: acquia-marina-script.js 7156 2010-04-24 16:48:35Z chris $

Drupal.behaviors.acquia_marinaRoundedCorners = function (context) {
  // Rounded corners - Inner background
  $(".inner .marina-rounded-corners .inner-wrapper .inner-inner").corner("bottom 7px"); 
  $(".inner .marina-title-rounded-blue h2.block-title").corner("top 5px"); 
  $(".inner .marina-title-rounded-green h2.block-title").corner("top 5px"); 
  $("#comments h2.comments-header").corner("top 5px"); 
};

Drupal.behaviors.acquia_marinaPanelsEditFix = function (context) {
  // Sets the .row class to have "overflow: visible" if editing Panel page
  $("#panels-edit-display-form").parents('.row', '.nested').css("overflow", "visible")
  $("#page-manager-edit").parents('.row', '.nested').css("overflow", "visible")
};
/*
$(function(){
    $('.SingupsRequestsPerEvent  td.views-field-nothing').each(function(){
        if (!$(this).children().length)
        {
            $(this).parent("tr").css("background-color","#99FFFF");
            $(this).parent("tr").find("td").css("background-color"," #99FFFF");
        }  
    });    
});
*/

$(function(){
    /*$(document).mouseout(function(event){
        if (!($(event.target).hasClass(".ActionItemFloat") || $(event.target).parents(".ActionItemFloat").length))
           $(".ActionItemFloat").slideUp("fast");
           CloseOverlay();
    });
    */
    $(".ActionItem").each(function(){
        $floatDiv = $(".ActionItemFloat",this);
        
        $(".ActionItemCommand",this).click(function(){
            $floatDiv = $(this).siblings().filter(".ActionItemFloat");
            if ($floatDiv.is(":hidden"))
            {
                CloseOverlay();
                $floatDiv.slideDown();
                OpenOverlay();
            }
            else 
            {
                CloseOverlay();
            }
        });
    }); 
    
    $(".flag-session-schedule.flagged").parents("td").addClass('cellhighlight');
    
    $(".PrintTicketsButton a, .EmptyTicketsButton a").click(function(event){
        if ($(".total").text() == "(0)")
        {
            alert('הסל ריק! הוסף ארועים לסל קודם.');
            event.stopPropagation();
            event.preventDefault();
        }
    }); 
	
	$(".TermsMenu .Term").click(function(){
	   $(this).toggleClass("Selected");
	   RefreshTerms();
	});
	
	var CountdownDate = new Date(2013, 9-1, 21);
	$('.CodCountDown').countdown({until: CountdownDate, format: 'yowdHMS',description: 'לתחילת פסטיבל אייקון 2013'});
}); 

function RefreshTerms() { 
    if ($(".TermsMenu .Term.Selected").length == 0) {
        $(".views-item.type-session").each(function(){
            $(this).parent().removeClass("DarkSession");
        });
        return;
    }

    $(".views-item.type-session").each(function(){
        $(this).parent().addClass("DarkSession");
    });

    $(".TermsMenu .Term.Selected").each(function(){
        $(".views-item.type-session[data-tags*=' "+$(this).attr("data-term")+" ']").each(function(){
            $(this).parent().removeClass("DarkSession");
        });
    });
}

function OpenOverlay()
{
    if ($(".ui-widget-overlay").length > 0)
        return;
        
      var $overlay = $('<div class="ui-overlay"><div class="ui-widget-overlay"></div></div>').hide().appendTo('body');
        $overlay.fadeIn();
        OverlayResize();

        $(window).resize(function () {
            OverlayResize();
        });
        
        $(".ui-widget-overlay").click(function(){
            CloseOverlay();
        });
}
function CloseOverlay()
{
    $(".ActionItemFloat").each(function(){
        $(this).slideUp("fast");
    });
    $(".ui-overlay").remove();
}

function OverlayResize()
{
             $('.ui-widget-overlay').width($(document).width()-100);
             $('.ui-widget-overlay').height($(document).height()-190);
}

function PrintTickets(ticketids)
{
    //var url="http://localhost:8080/cod";
    //var url="http://www.iconfestival.org.il/cod";
    var url="http://192.254.163.54/cod";
    var pathArray = window.location.pathname.split( '/' );
	pathArray = window.location.protocol + "//" +window.location.host+'/'+pathArray[1];
	//alert(pathArray);
    //var w = window.open(url+'/signupprint/'+ticketids,'','height=500,width=600, height=500,width=600, toolbar=no, menubar=no, scrollbars=yes, resizable=yes,location=no, directories=no, status=no, personalbar=no, directories=no, dialog=yes');
	var w = window.open(pathArray+'/signupprint/'+ticketids,'','height=500,width=600, height=500,width=600, toolbar=no, menubar=no, scrollbars=yes, resizable=yes,location=no, directories=no, status=no, personalbar=no, directories=no, dialog=yes');

}


// define a handler
function key_createtickets(e) {

    // this would test for "q" and the alt key at the same time
    if (e.altKey && e.keyCode == 81) 
	{
        // move to the createtickets page
        window.location.assign(document.URL.split("#")[0]+"/createtickets");
    }
}
// register the handler 
document.addEventListener('keyup', key_createtickets, false);
/*
$(document).ready(function() {
    $('a').each(function(){
        $(this).outerHTML = $(this).outerHTML.replace(/&amp;nbsp;/gi,'');
    });
});*/ 