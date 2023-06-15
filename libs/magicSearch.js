$(function () {
  var MagicSearch = function (domElement) {
    this.element = domElement;
    this.tbl = $(domElement).data("tbl");
    filter = domElement.value.toUpperCase();
    div = domElement.nextElementSibling;

    this.init = function () {
      $.ajax({
        url: "magicSearch.php",
        type: "get", //send it through get method
        data: {
          name: filter,
          table: this.tbl,
        },
        dataType: "JSON",
        success: function (res) {
          if (res.status.code == 0) {
            alert(res.status.msg);
          } else if (res.status.code == 1) {
            var items = "";

            list = JSON.parse(res.data);
            for (i = 0; i < list.length; i++) {
              items += "<a class='listItem' >" + list[i].name + "</a>";
            }
            div.innerHTML = items;
          }
        },
        error: function (error) {
          console.log("error occured");
        },
      });
    };

    // invoke the function.... rub the geni lamp
    this.init();
  };

  // setup my objects/instances
  $(".magicInput").keyup(function () {
    new MagicSearch(this);
  });
});
$(document).on("click", ".listItem", function (e) {
  var parrentInput = this.parentElement.previousElementSibling;
  parrentInput.value = this.innerHTML;
  $(this).siblings().hide();
  $(this).hide();
});
