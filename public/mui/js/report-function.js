/*
 * 锁定表头和列
 * 
 * 参数定义
 * 	table - 要锁定的表格元素或者表格ID
 * 	freezeRowNum - 要锁定的前几行行数，如果行不锁定，则设置为0
 * 	freezeColumnNum - 要锁定的前几列列数，如果列不锁定，则设置为0
 * 	width - 表格的滚动区域宽度
 * 	height - 表格的滚动区域高度
 */
 function freezeTable(table, freezeRowNum, freezeColumnNum, width, height) {
 	if (typeof(freezeRowNum) == 'string')
 		freezeRowNum = parseInt(freezeRowNum)
 	
 	if (typeof(freezeColumnNum) == 'string')
 		freezeColumnNum = parseInt(freezeColumnNum)

 	var tableId;
 	if (typeof(table) == 'string') {
 		tableId = table;
 		table = $('#' + tableId);
 	} else
 	tableId = table.attr('id');
 	
 	var divTableLayout = $("#" + tableId + "_tableLayout");
 	
 	if (divTableLayout.length != 0) {
 		divTableLayout.before(table);
 		divTableLayout.empty();
 	} else {
 		table.after("<div id='" + tableId + "_tableLayout' style='overflow:hidden;height:" + height + "px; width:" + width + "px; margin:0 auto; position:relative;'></div>");
 		
 		divTableLayout = $("#" + tableId + "_tableLayout");
 	}
 	
 	var html = '';
 	if (freezeRowNum > 0 && freezeColumnNum > 0)
 		html += '<div id="' + tableId + '_tableFix" style="padding: 0px;"></div>';
 	
 	if (freezeRowNum > 0)
 		html += '<div id="' + tableId + '_tableHead" style="padding: 0px;"></div>';
 	
 	if (freezeColumnNum > 0)
 		html += '<div id="' + tableId + '_tableColumn" style="padding: 0px; left:2px;"></div>';
 	
 	html += '<div id="' + tableId + '_tableData" style="padding: 0px;"></div>';
 	
 	
 	$(html).appendTo("#" + tableId + "_tableLayout");
 	
 	var divTableFix = freezeRowNum > 0 && freezeColumnNum > 0 ? $("#" + tableId + "_tableFix") : null;
 	var divTableHead = freezeRowNum > 0 ? $("#" + tableId + "_tableHead") : null;
 	var divTableColumn = freezeColumnNum > 0 ? $("#" + tableId + "_tableColumn") : null;
 	var divTableData = $("#" + tableId + "_tableData");
 	
 	divTableData.append(table);
 	
 	if (divTableFix != null) {
 		var tableFixClone = table.clone(true);
 		tableFixClone.attr("id", tableId + "_tableFixClone");
 		divTableFix.append(tableFixClone);
 	}
 	
 	if (divTableHead != null) {
 		var tableHeadClone = table.clone(true);
 		tableHeadClone.attr("id", tableId + "_tableHeadClone");
 		divTableHead.append(tableHeadClone);
 	}
 	
 	if (divTableColumn != null) {
 		var tableColumnClone = table.clone(true);
 		tableColumnClone.attr("id", tableId + "_tableColumnClone");
 		divTableColumn.append(tableColumnClone);
 	}
 	$("#" + tableId + "_tableLayout table").css("margin", "0");
 	
 	if (freezeRowNum > 0) {
 		var HeadHeight = 0;
 		var ignoreRowNum = 0;
 		$("#" + tableId + "_tableHead tr:lt(" + freezeRowNum + ")").each(function () {
 			if (ignoreRowNum > 0)
 				ignoreRowNum--;
 			else {
 				var td = $(this).find('td:first, th:first');
 				HeadHeight += td.outerHeight(true);
 				
 				ignoreRowNum = td.attr('rowSpan');
 				if (typeof(ignoreRowNum) == 'undefined')
 					ignoreRowNum = 0;
 				else
 					ignoreRowNum = parseInt(ignoreRowNum) - 1;
 			}
 		});
 		HeadHeight += 2;
 		
 		divTableHead.css("height", HeadHeight);
 		divTableFix != null && divTableFix.css("height", HeadHeight);
 	}
 	
 	if (freezeColumnNum > 0) {
 		var ColumnsWidth = 0;
 		var ColumnsNumber = 0;
 		$("#" + tableId + "_tableColumn tr:eq(0)").find("td:lt(" + freezeColumnNum + "), th:lt(" + freezeColumnNum + ")").each(function () {
 			if (ColumnsNumber >= freezeColumnNum)
 				return;
 			
 			ColumnsWidth += $(this).width();
 			ColumnsNumber += $(this).attr('colSpan') ? parseInt($(this).attr('colSpan')) : 1;
 		});
 		ColumnsWidth += 2;
 		divTableColumn.css("width", ColumnsWidth);
 		divTableFix != null && divTableFix.css("width", ColumnsWidth);
 	}
 	
 	divTableData.scroll(function () {
 		divTableHead != null && divTableHead.scrollLeft(divTableData.scrollLeft());
 		
 		divTableColumn != null && divTableColumn.scrollTop(divTableData.scrollTop());
 	});
 	
 	divTableFix != null && divTableFix.css({ "overflow": "hidden", "position": "absolute", "z-index": "50" });
 	divTableHead != null && divTableHead.css({ "overflow": "hidden", "width": width - 17, "position": "absolute", "z-index": "45" });
 	divTableColumn != null && divTableColumn.css({"overflow": "hidden", "height": height - 17, "position": "absolute", "z-index": "40"});
 	divTableData.css({ "overflow": "scroll", "width": width, "height": height, "position": "absolute" });
 	
 	divTableFix != null && divTableFix.offset(divTableLayout.offset());
 	divTableHead != null && divTableHead.offset(divTableLayout.offset());
 	divTableColumn != null && divTableColumn.offset(divTableLayout.offset());
 	divTableData.offset(divTableLayout.offset());
 }

/*
 * 调整锁定表的宽度和高度，这个函数在resize事件中调用
 * 
 * 参数定义
 * 	table - 要锁定的表格元素或者表格ID
 * 	width - 表格的滚动区域宽度
 * 	height - 表格的滚动区域高度
 */
 function adjustTableSize(table, width, height) {
 	var tableId;
 	if (typeof(table) == 'string')
 		tableId = table;
 	else
 		tableId = table.attr('id');
 	
 	$("#" + tableId + "_tableLayout").width(width).height(height);
 	$("#" + tableId + "_tableHead").width(width - 17);
 	$("#" + tableId + "_tableColumn").height(height - 17).css("left");
 	$("#" + tableId + "_tableData").width(width).height(height);
 }

 function pageHeight() {
 	if ($.browser.msie) {
 		return document.compatMode == "CSS1Compat" ? document.documentElement.clientHeight : document.body.clientHeight;
 	} else {
 		return self.innerHeight;
 	}
 };

//返回当前页面宽度
function pageWidth() {
	if ($.browser.msie) {
		return document.compatMode == "CSS1Compat" ? document.documentElement.clientWidth : document.body.clientWidth;
	} else {
		return self.innerWidth;
	}
};

$(document).ready(function() {
	var table = $("table");
	var tableId = table.attr('id');
	var freezeRowNum = table.attr('freezeRowNum');
	var freezeColumnNum = table.attr('freezeColumnNum');
    // var w = document.documentElement.clientWidth;
    // var h = document.documentElement.clientHeight;
    /*var w=window.innerWidth
    || document.documentElement.clientWidth
    || document.body.clientWidth;
    var h=window.innerHeight
    || document.documentElement.clientHeight
    || document.body.clientHeight;*/
	/*var width = w;
	var height = h;*/
	/**
	 * 获取屏幕宽高
	 * @type {[type]}
	 */
	 var height = document.documentElement.clientHeight;
	 var width = screen.width;
	 width = width == null ? pageWidth() : width;
	 height = height == null ? pageHeight() : height;
	 
	 if (typeof(freezeRowNum) != 'undefined' || typeof(freezeColumnNum) != 'undefined') {
	 	freezeTable(table, freezeRowNum || 0, freezeColumnNum || 0,width , height);
	 	
	 	var flag = false;
	 	$(window).resize(function() {
	 		if (flag) 
	 			return ;
	 		
	 		setTimeout(function() { 
	 			adjustTableSize(tableId,width , height); 
	 			flag = false; 
	 		}, 100);
	 		
	 		flag = true;
	 	});
	 }
	 var ajaxOperator = {
	 	update:function(e){
	 		var $this = $(this);
	 		var $options = e.data;
	 		if($this.val() == null || $.trim($this.val()) == ""){
	 			alert("数据不能为空!");
	 			$this.focus();
	 		}
	 		if($options.dataType == "int"){
	 			var v = $this.val();
				//var $pattern = /^\d+(\.\d+)?$/; //匹配非负整数
				var $pattern = /^\d+$/; //匹配非负整数
				if (!$pattern.test(v)) {
					alert("数据格式不正确!");
					$this.focus();
					return false;
				}
			}
			$this.parent().text(v);
		}	
	};
	$("#reportTable_tableData td").on("dblclick",function(){
		var $this = $(this);
		var $options = $this.data("options");
		if($options){
			if($options.editable){
				if($options.type == "text"){
					var $text = $('<input type="text" style="width:'+($this.width()-10)+'px;height:'+($this.height()-6)+'px;"/>');
					$(this).html($text);
					$text.focus().bind("blur",$options,ajaxOperator.update);
				}
			}
		}
		
	});
});