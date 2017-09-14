
$.fn.setTableColor = function(c1,c2){
	//this代表table的jquery对象
	//首行
	this.find("tr:first").css('background-color',c1);
	//其余行
	this.find("tr:gt(0):odd").css('background-color',c2);
}

 $(function(){
        $('table').setTableColor('#F9F9F9','#F9F9F9');
    });