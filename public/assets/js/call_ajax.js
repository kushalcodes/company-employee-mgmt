const call_ajax = (url, method, data, success) => {
  let ajaxObj = {
    type: method, // http method
    data: data,
    success: function (data, status, xhr) {
      success(JSON.parse(data));
    },
    error: function (jqXhr, textStatus, errorMessage) {
      console.log(textStatus, errorMessage);
    }
  };
  // if (method.toLowerCase() === 'put') {
  //   ajaxObj.contentType = 'application/json';
  //   ajaxObj.data = JSON.stringify(ajaxObj.data);
  // }
  $.ajax(url, ajaxObj);
};