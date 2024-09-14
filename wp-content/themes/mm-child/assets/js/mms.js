jQuery(document).ready(function ($) {
  var mms_searchInput = $("#mms_search");
  var mms_results_data = $("#mms_search_results");
  var mms_history = $("#mms_history");
  var mms_suggestions = $("#mms_search_suggestions");
  var mms_searchb = $("#mms_product_search");
  var mms_searchForm = $(".mms-search-form");
  var mms_history_clear = $("#mms_clear_history");
  var mms_cate_tab = $("#mms_search_cate_silde");
  var mms_history_item = $("#mms_history .mms-item-history");
  var mms_submit = $('#mms_product_search button[type="submit"]');

  function updateOrAddParamsToURL(url, params) {
    let newURL = new URL(url);
    for (let key in params) {
      if (params[key]) {
        newURL.searchParams.set(key, params[key]);
      } else {
        newURL.searchParams.delete(key);
      }
    }
    return newURL.toString();
  }

  mms_searchInput.on("focus input blur", function (e) {
    var query = mms_searchInput.val();

    if (e.type === "focus" && query.length === 0) {
      mms_history.show();
    } else if (e.type === "input") {
      mms_history.toggle(query.length === 0);
    }
  });

  mms_searchForm.on("click", function () {
    mms_searchForm.addClass("active");
  });

  $(document).on("click", function (e) {
    if (
      !mms_searchForm.is(e.target) &&
      mms_searchForm.has(e.target).length === 0
    ) {
      mms_searchForm.removeClass("active");
      mms_history.hide();
      mms_suggestions.hide();
    }
  });

  mms_searchInput.on("input", function () {
    var query = $(this).val();
    if (query.length >= 1) {
      mms_submit.prop("disabled", false);
      $.ajax({
        url: mmsAjax.ajaxurl,
        type: "POST",
        data: {
          action: "mms_ajax_s_suggestions",
          query: query,
        },
        beforeSend: function () {
          mms_suggestions.hide();
        },
        success: function (response) {
          mms_suggestions.empty();
          mms_suggestions.html(response).show();
          resetSuggestionClickHandler();
        },
        complete: function () {
          mms_suggestions.show();
        },
      });
    } else {
      mms_submit.prop("disabled", true);
      mms_suggestions.empty().hide();
    }
    console.log(query);
  });
  // Ajax Search Submit
  mms_searchb.on("submit", function (e) {
    e.preventDefault();
    var $button = $("#mms_load_more");
    var query = mms_searchInput.val();
    var category = new URLSearchParams(window.location.search).get("category");
    console.log(category);
    var currentUrl = window.location.pathname;
    if (!currentUrl.includes("/s/")) {
      var redirectUrl = "/s/?mms_search=" + encodeURIComponent(query);
      window.location.href = redirectUrl;
    } else {
      mms_suggestions.hide();
      var data = $(this).serialize() + "&action=mms_ajax_s";
      if (category) {
        data += "&category=" + encodeURIComponent(category);
      }
      var newUrl = updateOrAddParamsToURL(window.location.href, {
        mms_search: query,
      });

      if (window.history && window.history.pushState) {
        history.pushState({}, "", newUrl);
      }

      $.ajax({
        url: mmsAjax.ajaxurl,
        type: "GET",
        data: data,
        beforeSend: function () {
          $("#mms_search_loading").show();
        },
        success: function (response) {
          mms_suggestions.hide();
          if (response.products) {
            mms_results_data.html(response.products);
          }
          if (response.categories) {
            mms_cate_tab.html(response.categories);
          }
          console.log("Search Button Clicked");
          $button.data("page", 1);
        },
        complete: function () {
          $("#mms_search_loading").hide();
        },
        error: function (xhr, status, error) {
          console.error("AJAX error:", status, error);
        },
      });
    }
  });

  mms_history_clear.on("click", function () {
    $("#mms_history").remove();
    $.ajax({
      url: mmsAjax.ajaxurl,
      type: "POST",
      data: {
        action: "mms_clear_search_history",
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error:", error);
      },
    });
  });
  // Ajax Search Category
  mms_cate_tab.on("click", ".category", function () {
    var category = $(this).data("category");
    var $button = $("#mms_load_more");
    var currentPage = $button.data("page");
    var nextPage = currentPage + 1;
    
    var search_query = new URLSearchParams(window.location.search).get("mms_search");
    console.log("Keyword:" + search_query);
    console.log("cate:" + category);

    var newUrl = updateOrAddParamsToURL(window.location.href, {
      category: category,
    });

    if (window.history && window.history.pushState) {
      history.pushState({}, "", newUrl);
    } else {
      console.error("history.pushState is not supported");
    }

    $.ajax({
      url: mmsAjax.ajaxurl,
      type: "GET",
      data: {
        action: "mms_ajax_search_by_category",
        category: category,
      },
      beforeSend: function () {
        $("#mms_search_loading").show();
      },
      success: function (response) {
        mms_results_data.html(response);
        $button.data("page", nextPage);
        console.log("Search Category");
        $button.data("page", 1);
      },
      complete: function () {
        $("#mms_search_loading").hide();
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error:", error);
      },
    });
  });

  function resetSuggestionClickHandler() {
    var mms_s_suggestions = $(".s_suggestions");
    mms_s_suggestions.on("click", function () {
      var suggestion = $(this).data("suggestions");
      var newUrl = updateOrAddParamsToURL(window.location.href, {
        suggestion: suggestion,
      });

      if (window.history && window.history.pushState) {
        history.pushState({}, "", newUrl);
      } else {
        console.error("history.pushState is not supported");
      }

      $.ajax({
        url: mmsAjax.ajaxurl,
        type: "GET",
        data: {
          action: "mms_ajax_search_by_suggestion",
          suggestion: suggestion,
        },
        beforeSend: function () {
          $("#mms_search_loading").show();
        },
        success: function (response) {
          mms_results_data.html(response);
          console.log("Search Suggestion");
        },
        complete: function () {
          $("#mms_search_loading").hide();
        },
        error: function (xhr, status, error) {
          console.error("AJAX Error:", error);
        },
      });
    });
  }
  // Ajax Search History
  mms_history_item.on("click", function () {
    var historyValue = $(this).data("history");
    var $button = $("#mms_load_more");
    mms_submit.prop("disabled", false);
    var currentPage = $button.data("page");
    var nextPage = currentPage + 1;
    mms_searchInput.val(historyValue);

    var category = new URLSearchParams(window.location.search).get("category");
    console.log(category);

    var newUrl = updateOrAddParamsToURL(window.location.href, {
      mms_search: historyValue,
    });

    if (window.history && window.history.pushState) {
      history.pushState({}, "", newUrl);
    } else {
      console.error("history.pushState is not supported");
    }

    $.ajax({
      url: mmsAjax.ajaxurl,
      type: "GET",
      data: {
        action: "mms_ajax_search_by_history",
        history: historyValue,
        category: category
      },
      beforeSend: function () {
        mms_history.hide();
        $("#mms_search_loading").show();
      },
      success: function (response) {
        mms_results_data.html(response);
        $button.data("page", nextPage);
        console.log("Search by History");
        $button.data("page", 1);
      },
      complete: function () {
        $("#mms_search_loading").hide();
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error:", error);
      },
    });
  });

  $("#mms_load_more").on("click", function () {
    loadMoreProducts(this);
  });

  function loadMoreProducts(button) {
    var $button = $(button);
    var currentPage = $button.data("page");
    var nextPage = currentPage + 1;
    console.log(nextPage);
    var category = new URLSearchParams(window.location.search).get("category");
    var search_query = new URLSearchParams(window.location.search).get("mms_search");
    console.log('Ajax:' + category , search_query)


    $.ajax({
      url: mmsAjax.ajaxurl,
      type: "POST",
      data: {
        action: "mms_load_more_products",
        page: nextPage,
        mms_search: search_query,
        category: category
      },
      beforeSend: function () {
        $button.addClass("loading").html(`
                    <div class="waveform">
                        <div class="waveform__bar"></div>
                        <div class="waveform__bar"></div>
                        <div class="waveform__bar"></div>
                        <div class="waveform__bar"></div>
                    </div>
                `);
      },
      success: function (response) {
        if ($.trim(response)) {
          $("#mms_search_results").append(response);
          $button.data("page", nextPage);
          $button.removeClass("loading").text("Show more");
        } else {
          $button.hide();
        }
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error:", status, error);
        $button.removeClass("loading").text("Try again");
      },
    });
  }

  window.onpopstate = function (event) {
    if (event.state) {
      $.ajax({
        url: mmsAjax.ajaxurl,
        type: "GET",
        data: window.location.search.substring(1),
        success: function (response) {
          mms_results_data.html(response);
          console.log("Pagination loaded");
        },
        error: function (xhr, status, error) {
          console.error("AJAX Error:", status, error);
        },
        complete: function () {
          $("#mms_search_loading").hide();
        },
      });
    }
  };
});

var mms_range_datepicker = {
  next: "start",
  el: {},
};

jQuery(document).ready(function ($) {
  "use strict";
  console.log("Ready: jQuery " + $.fn.jquery);
  mms_range_datepicker.ui_options = {
    dateFormat: "yy-mm-dd",
    dayNamesMin: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
    minDate: 0,
    maxDate: "+1y",
    showButtonPanel: false,
    beforeShowDay: define_day_class,
    onSelect: populate_hidden_fields,
  };
  $("body").on("click", "#mms_search_datepicker_result", function () {
    if ($(this).hasClass("widget_hidden")) {
      mms_range_datepicker.ui_options.defaultDate = $(
        "#mms_search_datepicker_date_from"
      ).val()
        ? $("#mms_search_datepicker_date_from").val()
        : new Date();
      $("#mms_datepicker_widget").datepicker(mms_range_datepicker.ui_options);
      $("#mms_datepicker_widget").show();
    } else {
      $("#mms_datepicker_widget").datepicker("destroy");
      $("#mms_datepicker_widget").hide();
    }

    $(this).toggleClass("widget_hidden");
  });

  function define_day_class(date) {
    var date_from = $.datepicker.parseDate(
      "yy-mm-dd",
      $("#mms_search_datepicker_date_from").val()
    );
    var date_to = $.datepicker.parseDate(
      "yy-mm-dd",
      $("#mms_search_datepicker_date_to").val()
    );
    let selectable = true;
    let css_class = "";
    if (date_from && date.getTime() == date_from.getTime()) {
      css_class += " mm_range_picker__range_start";
    }
    if (date_to && date.getTime() == date_to.getTime()) {
      css_class += " mm_range_picker__range_end";
    }

    if (
      date_from &&
      date_to &&
      date.getTime() > date_from.getTime() &&
      date.getTime() < date_to.getTime()
    ) {
      css_class = "mm_range_picker__range_middle";
    }

    return [selectable, css_class];
  }

  function populate_hidden_fields(dateText, inst) {
    var date_from = $.datepicker.parseDate(
      "yy-mm-dd",
      $("#mms_search_datepicker_date_from").val()
    );
    var date_to = $.datepicker.parseDate(
      "yy-mm-dd",
      $("#mms_search_datepicker_date_to").val()
    );
    var selected = $.datepicker.parseDate("yy-mm-dd", dateText);

    if (!date_from && !date_to) {
      $("#mms_search_datepicker_date_from").val(dateText);
      $("#mms_search_datepicker_date_to").val(dateText);
      mms_range_datepicker.next = "end";
    } else if (date_from && selected < date_from) {
      $("#mms_search_datepicker_date_from").val(dateText);
      mms_range_datepicker.next = "end";
    } else if (!date_to && selected > date_from) {
      $("#mms_search_datepicker_date_to").val(dateText);
      mms_range_datepicker.next = "start";
    } else if (date_to && selected > date_to) {
      $("#mms_search_datepicker_date_to").val(dateText);
      mms_range_datepicker.next = "start";
    } else if (
      date_from &&
      date_to &&
      selected > date_from &&
      selected < date_to
    ) {
      if (mms_range_datepicker.next == "start") {
        $("#mms_search_datepicker_date_from").val(dateText);
      } else {
        $("#mms_search_datepicker_date_to").val(dateText);
      }
      mms_range_datepicker.next =
        mms_range_datepicker.next == "start" ? "end" : "start";
    }

    calculate_human_readable();
  }

  function calculate_human_readable() {
    var date_from = $.datepicker.parseDate(
      "yy-mm-dd",
      $("#mms_search_datepicker_date_from").val()
    );
    var date_to = $.datepicker.parseDate(
      "yy-mm-dd",
      $("#mms_search_datepicker_date_to").val()
    );

    console.log(date_from);
    console.log(date_to);

    let human_readable = "";

    if (date_from) {
      human_readable += $.datepicker.formatDate("d M", date_from);
    }
    console.log(human_readable);
    if (date_from && date_to) {
      if (
        $.datepicker.formatDate("d M", date_from) ==
        $.datepicker.formatDate("d M", date_to)
      ) {
      } else if (
        $.datepicker.formatDate("M", date_from) ==
        $.datepicker.formatDate("M", date_to)
      ) {
        human_readable =
          $.datepicker.formatDate("d", date_from) +
          " - " +
          $.datepicker.formatDate("d M", date_to);
      } else {
        human_readable += " - " + $.datepicker.formatDate("d M", date_to);
      }
    }

    $("#mms_search_datepicker_result").text(human_readable);
  }
});
