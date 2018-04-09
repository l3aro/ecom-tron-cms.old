

(function($) {
	$.fn.validationEngineLanguage = function() {};
	$.validationEngineLanguage = {
		newLang: function() {
			$.validationEngineLanguage.allRules = 	{
					"required":{    			// Add your regex rules here, you can take telephone as an example
						"regex":"none",
						"alertText":"* Bạn phải nhập thông tin này",
						"alertTextCheckboxMultiple":"* Xin hãy chọn một ô",
						"alertTextCheckboxe":"* Bạn phải tích vào ô này"},
					"length":{
						"regex":"none",
						"alertText":"*Phải có từ ",
						"alertText2":" đến ",
						"alertText3": " ký tự"},
					"maxCheckbox":{
						"regex":"none",
						"alertText":"* Checks allowed Exceeded"},	
					"minCheckbox":{
						"regex":"none",
						"alertText":"* Please select ",
						"alertText2":" options"},	
					"confirm":{
						"regex":"none",
						"alertText":"* Xác nhận chưa chính xác"},		
					"telephone":{
						"regex":"/^[0-9\-\(\)\ ]+$/",
						"alertText":"* Sai định dạng số điện thoại"},	
					"email":{
						"regex":"/^[a-zA-Z0-9_\.\-]+\@([a-zA-Z0-9\-]+\.)+[a-zA-Z0-9]{2,4}$/",
						"alertText":"* Sai định dạng email"},	
					"date":{
                         "regex":"/^[0-9]{4}\-\[0-9]{1,2}\-\[0-9]{1,2}$/",
                         "alertText":"* Ngày tháng năm không đúng, phải là định dạng YYYY-MM-DD"},
					"onlyNumber":{
						"regex":"/^[0-9\ ]+$/",
						"alertText":"* Chỉ được điền số"},	
					"noSpecialCaracters":{
						"regex":"/^[0-9a-zA-Z]+$/",
						"alertText":"* Không cho phép ký tự đặc biệt"},	
					"ajaxUser":{
						"file":"validateUser.php",
						"extraData":"name=eric",
						"alertTextOk":"* Tên sử dụng được phép dùng",	
						"alertTextLoad":"* Loading, Vui lòng chờ trong giây lát",
						"alertText":"* Tên sử dụng đã tồn tại, vui lòng điền tên sử dụng khác"},	
					"ajaxEmail":{
						"file":"validateUser.php",
						"extraData":"name=eric",
						"alertTextOk":"* Email được phép dùng",	
						"alertTextLoad":"* Loading, Vui lòng chờ trong giây lát",
						"alertText":"* Email đã được sử dụng, vui lòng điền email khác"},
					"ajaxName":{
						"file":"validateUser.php",
						"alertText":"* This name is already taken",
						"alertTextOk":"* This name is available",	
						"alertTextLoad":"* Loading, please wait"},		
					"onlyLetter":{
						"regex":"/^[a-zA-Z\ \']+$/",
						"alertText":"* Chỉ được điền chữ"},
					"validate2fields":{
    					"nname":"validate2fields",
    					"alertText":"* You must have a firstname and a lastname"}	
					}	
					
		}
	}
})(jQuery);

$(document).ready(function() {	
	$.validationEngineLanguage.newLang()
});