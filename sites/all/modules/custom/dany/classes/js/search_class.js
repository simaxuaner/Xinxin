(function ($) {
	Drupal.classes = Drupal.classes || {};
	/**
	 * Attach toggling behavior and notify the overlay of the toolbar.
 	*/
	Drupal.behaviors.classesearch = {
        attach: function(context) {
            $("a#search_class_button").click(function(){
            	var keywords = $("input#search_class_form").val();
            	if (keywords && $.trim(keywords) != "" && Drupal.settings.classmodule) {
	            	$.ajax( {    
	            	    url: Drupal.settings.classmodule.search_class_url,    
	            	    data:{    
	            	    	class_search_keywords: keywords,
	            	    	class_search_keywords_type: Drupal.settings.classmodule.class_search_keywords_type
	            	    },    
	            	    type:'post',    
	            	    cache:false,    
	            	    dataType:'json',    
	            	    success:function(data) {    
	            	        if(data.code =="200" ){    
	            	            $(".search_class_form_list").html(data.html);
	            	            $(".search_class_form_list_append").remove();
	            	        }else{    
	            	            alert(data.html);   
	            	        }    
	            	     },    
	            	     error : function() { 
	            	          alert("搜索异常！");    
	            	     }
	            	});
            	}
            });
        }
	};
})(jQuery);	