// JavaScript Document
function build_md_select(obj){
	
	obj.closest('.form_field').find('div.cd-dropdown').remove();
	
	if(obj.attr('data-effect')=='stack')
			{
			obj.dropdown( {
					gutter : 5,
					effect : 'stack',
					select_obj : obj
				} );
			}
		else if(obj.attr('data-effect')=='angled')
			{
			obj.dropdown( {
					gutter : 5,
					delay : 100,
					random : true,
					effect : 'angled',
					select_obj : obj
				} );
			}
		else if(obj.attr('data-effect')=='fanned')
			{
			obj.dropdown( {
					gutter : 5,
					delay : 40,
					effect : 'fanned',
					rotated : 'left',
					select_obj : obj
				} );
			}
		else if(obj.attr('data-effect')=='slide-in')
			{
			obj.dropdown( {
					gutter : 5,
					stack : false,
					slidingIn : 100,
					effect : 'slide-in',
					select_obj : obj
				} );
			}
		else
			obj.dropdown({ select_obj : obj });	
	
}


jQuery(document).ready(
function ()
	{
	
	jQuery(function() {
	 
	});
	
	
  //document.oncontextmenu = function() {return false;};

 /*jQuery('.nex-forms-container .form_field').live('mousedown',function(e){ 
    if( e.button == 2 ) { 
      
	   jQuery(jQuery(this)).contextMenu( '#menu' , {} );
	   
      return false; 
    } 
    return true; 
  }); 
*/
	
	

	
	/*jQuery('.overall-form-settings .dropdown-menu li').click(
		function()
			{
			
			
			jQuery('.overall-form-settings li').removeClass('active');
			
			jQuery('.overall-form-settings .current_selected_theme').text(jQuery(this).find('a').text());
			jQuery('.active_theme').text(jQuery(this).attr('class'));
			
			jQuery(this).addClass('active');
			
			if(jQuery(this).attr('class')=='default')
				{
				jQuery('link.color_scheme').attr('href',"#");
				jQuery('.ui-state-default').removeClass('ui-state-default');
				jQuery('.ui-state-active').removeClass('ui-state-active');
				jQuery('.ui-widget-content').removeClass('ui-widget-content');
				jQuery('.ui-widget-header').removeClass('ui-widget-header');
				}
			}
		);*/
		
		
	
	
	
	
	jQuery('.open_nex_forms_popup').click(
		function(e)
			{
			e.preventDefault();
			jQuery('#nexForms_popup_'+jQuery(this).attr('data-popup-id')).modal().appendTo('body');
			}
		)
	/*******************************/
	/********* FORM FIELDS *********/
	/*******************************/
	
	//Awsome Checks
	jQuery('div.checkbox-group input').each(
		function()
			{
			jQuery(this).prettyCheckable();	
			}
		);
	jQuery('#available_fields a, #canvas_view a').click(function (e) {
	  e.preventDefault()
	  jQuery(this).tab('show')
	})
	
	
	jQuery('.bs-tooltip').tooltip();

	/*********************************/
	/********* ADMIN BUILDER *********/
	/*********************************/
	//Boostrap Accordion
	
	
	var get_input_style = '';
	jQuery('.the_input_element.form-control').on('focus',
		function()
			{
			get_input_style = jQuery(this).attr('style');
			if(jQuery(this).attr('data-drop-focus-swadow')=='1')
				jQuery(this).attr('style',get_input_style + 'box-shadow:inset 0 1px 1px rgba(0,0,0,0.075), 0 0 7px ' +  jQuery(this).attr('data-onfocus-color') +' !important;border-color:'+ jQuery(this).attr('data-onfocus-color') +' !important;')
			else
				jQuery(this).attr('style',get_input_style + 'border-color:'+ jQuery(this).attr('data-onfocus-color') +' !important;')
			}
		);
	jQuery('.the_input_element.form-control').on('blur',
		function()
			{
			jQuery(this).attr('style',get_input_style);
			}
		);
		
	jQuery('.input-group-addon.prefix, .input-group-addon.postfix').click(
		function()
			{
			jQuery(this).parent().find('input').trigger('focus');
			}
		);
	
	}
);

function format_illegal_chars(input_value){
	
	if(!input_value)
		return;
	
	input_value = input_value.toLowerCase();
	if(input_value=='name' || input_value=='page' || input_value=='post' || input_value=='id')
		input_value = '_'+input_value;
		
	var illigal_chars = '-+=!@#$%^&*()*{}[]:;<>,.?~`|/\'';
	
	var new_value ='';
	
    for(i=0;i<input_value.length;i++)
		{
		if (illigal_chars.indexOf(input_value.charAt(i)) != -1)
			{
			input_value.replace(input_value.charAt(i),'');
			}
		else
			{
			if(input_value.charAt(i)==' ')
			new_value += '_';
			else
			new_value += input_value.charAt(i);
			}
		}
	return new_value;	
}


function colorToHex(color) {
	if(!color)
		return;
	
    if (color.substr(0, 1) === '#') {
        return color;
    }
    var digits = /(.*?)rgb\((\d+), (\d+), (\d+)\)/.exec(color);
    if(!digits)
		return '#FFF';
	
    var red = parseInt(digits[2]);
    var green = parseInt(digits[3]);
    var blue = parseInt(digits[4]);
    
    var rgb = blue | (green << 8) | (red << 16);
    return digits[1] + '#' + rgb.toString(16);
};

function strstr(haystack, needle, bool) {
    var pos = 0;

    haystack += "";
    pos = haystack.indexOf(needle); if (pos == -1) {
       return false;
    } else {
       return true;
    }
}

!function(t,i){"use strict";var e,s=t.document,n=s.documentElement,o=t.Modernizr,r=function(t){return t.charAt(0).toUpperCase()+t.slice(1)},a="Moz Webkit O Ms".split(" "),h=function(t){var i,e=n.style;if("string"==typeof e[t])return t;t=r(t);for(var s=0,o=a.length;o>s;s++)if(i=a[s]+t,"string"==typeof e[i])return i},l=h("transform"),u=h("transitionProperty"),c={csstransforms:function(){return!!l},csstransforms3d:function(){var t=!!h("perspective");if(t&&"webkitPerspective"in n.style){var e=i("<style>@media (transform-3d),(-webkit-transform-3d){#modernizr{height:3px}}</style>").appendTo("head"),s=i('<div id="modernizr" />').appendTo("html");t=3===s.height(),s.remove(),e.remove()}return t},csstransitions:function(){return!!u}};if(o)for(e in c)o.hasOwnProperty(e)||o.addTest(e,c[e]);else{o=t.Modernizr={_version:"1.6ish: miniModernizr for catogorize_it"};var d,f=" ";for(e in c)d=c[e](),o[e]=d,f+=" "+(d?"":"no-")+e;i("").addClass(f)}if(o.csstransforms){var m=o.csstransforms3d?{translate:function(t){return"translate3d("+t[0]+"px, "+t[1]+"px, 0) "},scale:function(t){return"scale3d("+t+", "+t+", 1) "}}:{translate:function(t){return"translate("+t[0]+"px, "+t[1]+"px) "},scale:function(t){return"scale("+t+") "}},p=function(t,e,s){var n,o,r=i.data(t,"isoTransform")||{},a={},h={};a[e]=s,i.extend(r,a);for(n in r)o=r[n],h[n]=m[n](o);var u=h.translate||"",c=h.scale||"",d=u+c;i.data(t,"isoTransform",r),t.style[l]=d};i.cssNumber.scale=!0,i.cssHooks.scale={set:function(t,i){p(t,"scale",i)},get:function(t){var e=i.data(t,"isoTransform");return e&&e.scale?e.scale:1}},i.fx.step.scale=function(t){i.cssHooks.scale.set(t.elem,t.now+t.unit)},i.cssNumber.translate=!0,i.cssHooks.translate={set:function(t,i){p(t,"translate",i)},get:function(t){var e=i.data(t,"isoTransform");return e&&e.translate?e.translate:[0,0]}}}var y,g;o.csstransitions&&(y={WebkitTransitionProperty:"webkitTransitionEnd",MozTransitionProperty:"transitionend",OTransitionProperty:"oTransitionEnd otransitionend",transitionProperty:"transitionend"}[u],g=h("transitionDuration"));var _,v=i.event,z=i.event.handle?"handle":"dispatch";v.special.smartresize={setup:function(){i(this).bind("resize",v.special.smartresize.handler)},teardown:function(){i(this).unbind("resize",v.special.smartresize.handler)},handler:function(t,i){var e=this,s=arguments;t.type="smartresize",_&&clearTimeout(_),_=setTimeout(function(){v[z].apply(e,s)},"execAsap"===i?0:100)}},i.fn.smartresize=function(t){return t?this.bind("smartresize",t):this.trigger("smartresize",["execAsap"])},i.catogorize_it=function(t,e,s){this.element=i(e),this._create(t),this._init(s)};var A=["width","height"],w=i(t);i.catogorize_it.settings={resizable:!0,layoutMode:"masonry",containerClass:"categorize_it",itemClass:"categorize_it-item",hiddenClass:"categorize_it-hidden",hiddenStyle:{opacity:0,scale:.001},visibleStyle:{opacity:1,scale:1},containerStyle:{position:"relative",overflow:"hidden"},animationEngine:"best-available",animationOptions:{queue:!1,duration:800},sortBy:"original-order",sortAscending:!0,resizesContainer:!0,transformsEnabled:!0,itemPositionDataEnabled:!1},i.catogorize_it.prototype={_create:function(t){this.options=i.extend({},i.catogorize_it.settings,t),this.styleQueue=[],this.elemCount=0;var e=this.element[0].style;this.originalStyle={};var s=A.slice(0);for(var n in this.options.containerStyle)s.push(n);for(var o=0,r=s.length;r>o;o++)n=s[o],this.originalStyle[n]=e[n]||"";this.element.css(this.options.containerStyle),this._updateAnimationEngine(),this._updateUsingTransforms();var a={"original-order":function(t,i){return i.elemCount++,i.elemCount},random:function(){return Math.random()}};this.options.getSortData=i.extend(this.options.getSortData,a),this.reloadItems(),this.offset={left:parseInt(this.element.css("padding-left")||0,10),top:parseInt(this.element.css("padding-top")||0,10)};var h=this;setTimeout(function(){h.element.addClass(h.options.containerClass)},0),this.options.resizable&&w.bind("smartresize.categorize_it",function(){h.resize()}),this.element.delegate("."+this.options.hiddenClass,"click",function(){return!1})},_getAtoms:function(t){var i=this.options.itemSelector,e=i?t.filter(i).add(t.find(i)):t,s={position:"absolute"};return e=e.filter(function(t,i){return 1===i.nodeType}),this.usingTransforms&&(s.left=0,s.top=0),e.css(s).addClass(this.options.itemClass),this.updateSortData(e,!0),e},_init:function(t){this.$filteredAtoms=this._filter(this.$allAtoms),this._sort(),this.reLayout(t)},option:function(t){if(i.isPlainObject(t)){this.options=i.extend(!0,this.options,t);var e;for(var s in t)e="_update"+r(s),this[e]&&this[e]()}},_updateAnimationEngine:function(){var t,i=this.options.animationEngine.toLowerCase().replace(/[ _\-]/g,"");switch(i){case"css":case"none":t=!1;break;case"jquery":t=!0;break;default:t=!o.csstransitions}this.isUsingJQueryAnimation=t,this._updateUsingTransforms()},_updateTransformsEnabled:function(){this._updateUsingTransforms()},_updateUsingTransforms:function(){var t=this.usingTransforms=this.options.transformsEnabled&&o.csstransforms&&o.csstransitions&&!this.isUsingJQueryAnimation;t||(delete this.options.hiddenStyle.scale,delete this.options.visibleStyle.scale),this.getPositionStyles=t?this._translate:this._positionAbs},_filter:function(t){var i=""===this.options.filter?"*":this.options.filter;if(!i)return t;var e=this.options.hiddenClass,s="."+e,n=t.filter(s),o=n;if("*"!==i){o=n.filter(i);var r=t.not(s).not(i).addClass(e);this.styleQueue.push({$el:r,style:this.options.hiddenStyle})}return this.styleQueue.push({$el:o,style:this.options.visibleStyle}),o.removeClass(e),t.filter(i)},updateSortData:function(t,e){var s,n,o=this,r=this.options.getSortData;t.each(function(){s=i(this),n={};for(var t in r)n[t]=e||"original-order"!==t?r[t](s,o):i.data(this,"categorize_it-sort-data")[t];i.data(this,"categorize_it-sort-data",n)})},_sort:function(){var t=this.options.sortBy,i=this._getSorter,e=this.options.sortAscending?1:-1,s=function(s,n){var o=i(s,t),r=i(n,t);return o===r&&"original-order"!==t&&(o=i(s,"original-order"),r=i(n,"original-order")),(o>r?1:r>o?-1:0)*e};this.$filteredAtoms.sort(s)},_getSorter:function(t,e){return i.data(t,"categorize_it-sort-data")[e]},_translate:function(t,i){return{translate:[t,i]}},_positionAbs:function(t,i){return{left:t,top:i}},_pushPosition:function(t,i,e){i=Math.round(i+this.offset.left),e=Math.round(e+this.offset.top);var s=this.getPositionStyles(i,e);this.styleQueue.push({$el:t,style:s}),this.options.itemPositionDataEnabled&&t.data("categorize_it-item-position",{x:i,y:e})},layout:function(t,i){var e=this.options.layoutMode;if(this["_"+e+"Layout"](t),this.options.resizesContainer){var s=this["_"+e+"GetContainerSize"]();this.styleQueue.push({$el:this.element,style:s})}this._processStyleQueue(t,i),this.isLaidOut=!0},_processStyleQueue:function(t,e){var s,n,r,a,h=this.isLaidOut&&this.isUsingJQueryAnimation?"animate":"css",l=this.options.animationOptions,u=this.options.onLayout;if(n=function(t,i){i.$el[h](i.style,l)},this._isInserting&&this.isUsingJQueryAnimation)n=function(t,i){s=i.$el.hasClass("no-transition")?"css":h,i.$el[s](i.style,l)};else if(e||u||l.complete){var c=!1,d=[e,u,l.complete],f=this;if(r=!0,a=function(){if(!c){for(var i,e=0,s=d.length;s>e;e++)i=d[e],"function"==typeof i&&i.call(f.element,t,f);c=!0}},this.isUsingJQueryAnimation&&"animate"===h)l.complete=a,r=!1;else if(o.csstransitions){for(var m,p=0,_=this.styleQueue[0],v=_&&_.$el;!v||!v.length;){if(m=this.styleQueue[p++],!m)return;v=m.$el}var z=parseFloat(getComputedStyle(v[0])[g]);z>0&&(n=function(t,i){i.$el[h](i.style,l).one(y,a)},r=!1)}}i.each(this.styleQueue,n),r&&a(),this.styleQueue=[]},resize:function(){this["_"+this.options.layoutMode+"ResizeChanged"]()&&this.reLayout()},reLayout:function(t){this["_"+this.options.layoutMode+"Reset"](),this.layout(this.$filteredAtoms,t)},addItems:function(t,i){var e=this._getAtoms(t);this.$allAtoms=this.$allAtoms.add(e),i&&i(e)},insert:function(t,i){this.element.append(t);var e=this;this.addItems(t,function(t){var s=e._filter(t);e._addHideAppended(s),e._sort(),e.reLayout(),e._revealAppended(s,i)})},appended:function(t,i){var e=this;this.addItems(t,function(t){e._addHideAppended(t),e.layout(t),e._revealAppended(t,i)})},_addHideAppended:function(t){this.$filteredAtoms=this.$filteredAtoms.add(t),t.addClass("no-transition"),this._isInserting=!0,this.styleQueue.push({$el:t,style:this.options.hiddenStyle})},_revealAppended:function(t,i){var e=this;setTimeout(function(){t.removeClass("no-transition"),e.styleQueue.push({$el:t,style:e.options.visibleStyle}),e._isInserting=!1,e._processStyleQueue(t,i)},10)},reloadItems:function(){this.$allAtoms=this._getAtoms(this.element.children())},remove:function(t,i){this.$allAtoms=this.$allAtoms.not(t),this.$filteredAtoms=this.$filteredAtoms.not(t);var e=this,s=function(){t.remove(),i&&i.call(e.element)};t.filter(":not(."+this.options.hiddenClass+")").length?(this.styleQueue.push({$el:t,style:this.options.hiddenStyle}),this._sort(),this.reLayout(s)):s()},shuffle:function(t){this.updateSortData(this.$allAtoms),this.options.sortBy="random",this._sort(),this.reLayout(t)},destroy:function(){var t=this.usingTransforms,i=this.options;this.$allAtoms.removeClass(i.hiddenClass+" "+i.itemClass).each(function(){var i=this.style;i.position="",i.top="",i.left="",i.opacity="",t&&(i[l]="")});var e=this.element[0].style;for(var s in this.originalStyle)e[s]=this.originalStyle[s];this.element.unbind(".categorize_it").undelegate("."+i.hiddenClass,"click").removeClass(i.containerClass).removeData("categorize_it"),w.unbind(".categorize_it")},_getSegments:function(t){var i,e=this.options.layoutMode,s=t?"rowHeight":"columnWidth",n=t?"height":"width",o=t?"rows":"cols",a=this.element[n](),h=this.options[e]&&this.options[e][s]||this.$filteredAtoms["outer"+r(n)](!0)||a;i=Math.floor(a/h),i=Math.max(i,1),this[e][o]=i,this[e][s]=h},_checkIfSegmentsChanged:function(t){var i=this.options.layoutMode,e=t?"rows":"cols",s=this[i][e];return this._getSegments(t),this[i][e]!==s},_masonryReset:function(){this.masonry={},this._getSegments();var t=this.masonry.cols;for(this.masonry.colYs=[];t--;)this.masonry.colYs.push(0)},_masonryLayout:function(t){var e=this,s=e.masonry;t.each(function(){var t=i(this),n=Math.ceil(t.outerWidth(!0)/s.columnWidth);if(n=Math.min(n,s.cols),1===n)e._masonryPlaceBrick(t,s.colYs);else{var o,r,a=s.cols+1-n,h=[];for(r=0;a>r;r++)o=s.colYs.slice(r,r+n),h[r]=Math.max.apply(Math,o);e._masonryPlaceBrick(t,h)}})},_masonryPlaceBrick:function(t,i){for(var e=Math.min.apply(Math,i),s=0,n=0,o=i.length;o>n;n++)if(i[n]===e){s=n;break}var r=this.masonry.columnWidth*s,a=e;this._pushPosition(t,r,a);var h=e+t.outerHeight(!0),l=this.masonry.cols+1-o;for(n=0;l>n;n++)this.masonry.colYs[s+n]=h},_masonryGetContainerSize:function(){var t=Math.max.apply(Math,this.masonry.colYs);return{height:t}},_masonryResizeChanged:function(){return this._checkIfSegmentsChanged()},_fitRowsReset:function(){this.fitRows={x:0,y:0,height:0}},_fitRowsLayout:function(t){var e=this,s=this.element.width(),n=this.fitRows;t.each(function(){var t=i(this),o=t.outerWidth(!0),r=t.outerHeight(!0);0!==n.x&&o+n.x>s&&(n.x=0,n.y=n.height),e._pushPosition(t,n.x,n.y),n.height=Math.max(n.y+r,n.height),n.x+=o})},_fitRowsGetContainerSize:function(){return{height:this.fitRows.height}},_fitRowsResizeChanged:function(){return!0},_cellsByRowReset:function(){this.cellsByRow={index:0},this._getSegments(),this._getSegments(!0)},_cellsByRowLayout:function(t){var e=this,s=this.cellsByRow;t.each(function(){var t=i(this),n=s.index%s.cols,o=Math.floor(s.index/s.cols),r=(n+.5)*s.columnWidth-t.outerWidth(!0)/2,a=(o+.5)*s.rowHeight-t.outerHeight(!0)/2;e._pushPosition(t,r,a),s.index++})},_cellsByRowGetContainerSize:function(){return{height:Math.ceil(this.$filteredAtoms.length/this.cellsByRow.cols)*this.cellsByRow.rowHeight+this.offset.top}},_cellsByRowResizeChanged:function(){return this._checkIfSegmentsChanged()},_straightDownReset:function(){this.straightDown={y:0}},_straightDownLayout:function(t){var e=this;t.each(function(){var t=i(this);e._pushPosition(t,0,e.straightDown.y),e.straightDown.y+=t.outerHeight(!0)})},_straightDownGetContainerSize:function(){return{height:this.straightDown.y}},_straightDownResizeChanged:function(){return!0},_masonryHorizontalReset:function(){this.masonryHorizontal={},this._getSegments(!0);var t=this.masonryHorizontal.rows;for(this.masonryHorizontal.rowXs=[];t--;)this.masonryHorizontal.rowXs.push(0)},_masonryHorizontalLayout:function(t){var e=this,s=e.masonryHorizontal;t.each(function(){var t=i(this),n=Math.ceil(t.outerHeight(!0)/s.rowHeight);if(n=Math.min(n,s.rows),1===n)e._masonryHorizontalPlaceBrick(t,s.rowXs);else{var o,r,a=s.rows+1-n,h=[];for(r=0;a>r;r++)o=s.rowXs.slice(r,r+n),h[r]=Math.max.apply(Math,o);e._masonryHorizontalPlaceBrick(t,h)}})},_masonryHorizontalPlaceBrick:function(t,i){for(var e=Math.min.apply(Math,i),s=0,n=0,o=i.length;o>n;n++)if(i[n]===e){s=n;break}var r=e,a=this.masonryHorizontal.rowHeight*s;this._pushPosition(t,r,a);var h=e+t.outerWidth(!0),l=this.masonryHorizontal.rows+1-o;for(n=0;l>n;n++)this.masonryHorizontal.rowXs[s+n]=h},_masonryHorizontalGetContainerSize:function(){var t=Math.max.apply(Math,this.masonryHorizontal.rowXs);return{width:t}},_masonryHorizontalResizeChanged:function(){return this._checkIfSegmentsChanged(!0)},_fitColumnsReset:function(){this.fitColumns={x:0,y:0,width:0}},_fitColumnsLayout:function(t){var e=this,s=this.element.height(),n=this.fitColumns;t.each(function(){var t=i(this),o=t.outerWidth(!0),r=t.outerHeight(!0);0!==n.y&&r+n.y>s&&(n.x=n.width,n.y=0),e._pushPosition(t,n.x,n.y),n.width=Math.max(n.x+o,n.width),n.y+=r})},_fitColumnsGetContainerSize:function(){return{width:this.fitColumns.width}},_fitColumnsResizeChanged:function(){return!0},_cellsByColumnReset:function(){this.cellsByColumn={index:0},this._getSegments(),this._getSegments(!0)},_cellsByColumnLayout:function(t){var e=this,s=this.cellsByColumn;t.each(function(){var t=i(this),n=Math.floor(s.index/s.rows),o=s.index%s.rows,r=(n+.5)*s.columnWidth-t.outerWidth(!0)/2,a=(o+.5)*s.rowHeight-t.outerHeight(!0)/2;e._pushPosition(t,r,a),s.index++})},_cellsByColumnGetContainerSize:function(){return{width:Math.ceil(this.$filteredAtoms.length/this.cellsByColumn.rows)*this.cellsByColumn.columnWidth}},_cellsByColumnResizeChanged:function(){return this._checkIfSegmentsChanged(!0)},_straightAcrossReset:function(){this.straightAcross={x:0}},_straightAcrossLayout:function(t){var e=this;t.each(function(){var t=i(this);e._pushPosition(t,e.straightAcross.x,0),e.straightAcross.x+=t.outerWidth(!0)})},_straightAcrossGetContainerSize:function(){return{width:this.straightAcross.x}},_straightAcrossResizeChanged:function(){return!0}},i.fn.imagesLoaded=function(t){function e(){t.call(n,o)}function s(t){var n=t.target;n.src!==a&&-1===i.inArray(n,h)&&(h.push(n),--r<=0&&(setTimeout(e),o.unbind(".imagesLoaded",s)))}var n=this,o=n.find("img").add(n.filter("img")),r=o.length,a="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==",h=[];return r||e(),o.bind("load.imagesLoaded error.imagesLoaded",s).each(function(){var t=this.src;this.src=a,this.src=t}),n};var C=function(i){t.console&&t.console.error(i)};i.fn.categorize_it=function(t,e){if("string"==typeof t){var s=Array.prototype.slice.call(arguments,1);this.each(function(){var e=i.data(this,"categorize_it");return e?i.isFunction(e[t])&&"_"!==t.charAt(0)?void e[t].apply(e,s):void C("no such method '"+t+"' for categorize_it instance"):void C("cannot call methods on categorize_it prior to initialization; attempted to call method '"+t+"'")})}else this.each(function(){var s=i.data(this,"categorize_it");s?(s.option(t),s._init(e)):i.data(this,"categorize_it",new i.catogorize_it(t,this,e))});return this}}(window,jQuery);