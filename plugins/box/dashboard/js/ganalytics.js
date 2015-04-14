if (typeof $.promo == 'undefined') $.promo = {};

function glibOnloadHandle(){$.promo.ganalytics.libOnloadHandle();}

$.promo.ganalytics = {

    conf: {
        clientId: '',
        apiKey: '',
        viewId: '',
        authScopes: 'https://www.googleapis.com/auth/analytics.readonly'
    },

    _gaAreas: '#authOk,#authFail,#gaSettings,#gaLoading,#reauthError,#gaHelpLink',
    _startDate: moment().subtract('days', 29),
    _endDate: moment(),
    
    init: function(data){
        $.extend(this.conf, data);
        $('.gaSettingsLink').click(function(){
            $.promo.ganalytics.show('#gaSettings,#gaHelpLink');
			$('.gaSettingsLink').hide();
        });
    },
    
    initDateRangePicker: function(){
        $('#reportRange').daterangepicker({
              ranges: {
                 'Today': [moment(), moment()],
                 'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                 'Last 7 Days': [moment().subtract('days', 6), moment()],
                 'Last 30 Days': [moment().subtract('days', 29), moment()],
                 'This Month': [moment().startOf('month'), moment().endOf('month')],
                 'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
              },
              startDate: $.promo.ganalytics._startDate,
              endDate: $.promo.ganalytics._endDate
            },function(start, end) {
                $.promo.ganalytics.getAnalyticsInfo(start._d, end._d);
            }
        );
        $.promo.ganalytics.getAnalyticsInfo($.promo.ganalytics._startDate._d, $.promo.ganalytics._endDate._d);
    },
    
    libOnloadHandle: function(){
        if ($.promo.ganalytics.conf.clientId == '' 
            || $.promo.ganalytics.conf.apiKey == '' 
            || $.promo.ganalytics.conf.viewId == ''
        ) {
            $.promo.ganalytics.show('#gaSettings,#gaHelpLink');
			$('.gaSettingsLink').hide();
            return false;
        }
        gapi.client.setApiKey(this.conf.apiKey);
        window.setTimeout(function(){
            $.promo.ganalytics.checkAuth(true);
        },1);
    },

    checkAuth: function(immediate){
        gapi.auth.authorize({
            client_id: $.promo.ganalytics.conf.clientId,
            scope: $.promo.ganalytics.conf.authScopes,
            immediate: immediate
        }, $.promo.ganalytics.handleAuthResult);
        return immediate;
    },

    handleAuthResult: function(authResult){
        if (authResult && !authResult.error) {
            $.promo.ganalytics.show('#authOk');
            $.promo.ganalytics.initDateRangePicker();
        } else {
            $.promo.ganalytics.show('#authFail');
            if (authResult && typeof authResult.error != 'undefined') {
                $.promo.ganalytics.showError(authResult.error.message);
            }
            
            $('#authorizeButton').on('click', function(e){
                $.promo.ganalytics.checkAuth(false);
            });
        }
    },

    getAnalyticsInfo: function(startDate, endDate) {
        gapi.client.load('analytics', 'v3', function(){
            gapi.client.analytics.data.ga.get({
                'ids': 'ga:'+ $.promo.ganalytics.conf.viewId,
                'start-date': $.promo.ganalytics.formatDate(startDate),
                'end-date': $.promo.ganalytics.formatDate(endDate),
                'metrics': 'ga:visits,ga:pageviews,ga:visitors',
                'dimensions': 'ga:date'
            }).execute($.promo.ganalytics.gaReportingResults);
        });
    },

    gaReportingResults: function(res){
        if (typeof res.error != 'undefined' && typeof res.error.message != 'undefined') {
            $.promo.ganalytics.showError(res.error.message, res.error.code);
            return;
        }
        
        // build chart data
        var dataArr = [['Date', 'Visits']];
        for (r in res.rows) {
            var tmpr = [];
            for (h in res.columnHeaders) {
                if (res.columnHeaders[h].name == 'ga:visits') {
                    tmpr[1] = parseInt(res.rows[r][h]);
                } else if (res.columnHeaders[h].name == 'ga:date') {
                    var parsed = res.rows[r][h].match(/([0-9]{4})([0-9]{2})([0-9]{2})/)
                    tmpr[0] = parsed[1] +'-'+ parsed[2] +'-'+ parsed[3];
                }
                
                if (res.rows.length == (parseInt(r)+1)) {
                    switch(res.columnHeaders[h].name) {
                        case 'ga:visits': $.promo.ganalytics.setVisits(res.rows[r][h]); break;
                        case 'ga:pageviews': $.promo.ganalytics.setPageviews(res.rows[r][h]); break;
                        case 'ga:visitors': $.promo.ganalytics.setVisitors(res.rows[r][h]); break;
                    }
                }
            }
            dataArr.push(tmpr);
        }
        
        var data = google.visualization.arrayToDataTable(dataArr);

        var options = {
          title: 'Visits',
          hAxis: {title: 'Date',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('gaChart'));
        chart.draw(data, options);
        
    },

    formatDate: function(dateObj){
        var m = dateObj.getMonth()+1;
        var d = dateObj.getDate();
        m = m > 9 ? m : '0'+m;
        d = d > 9 ? d : '0'+d;
        return dateObj.getFullYear() +'-'+ m +'-'+ d;
    },

    show: function(selector){
		$('.gaSettingsLink').show();
        $('#gaAlerts').html('');
        $($.promo.ganalytics._gaAreas).addClass('hide');
        $(selector).removeClass('hide').show();
    },

    showError: function(msg, errCode){
		if (typeof errCode !== 'undefined' && errCode == 403) {
			$.promo.ganalytics.show('#reauthError,#gaHelpLink');
		} else {
			$.promo.ganalytics.show('#gaHelpLink');
		}
        $('#gaAlerts').html(msg);
		$('#authOk').addClass('hide');
    },
    
    setVisits: function(val){
        $('#gaVisits').html(val);
    },
    
    setVisitors: function(val){
        $('#gaVisitors').html(val);
    },
    
    setPageviews: function(val){
        $('#gaPageviews').html(val);
    }
};

$(document).ready(function(){
    $val_gaInitData = $('#gaInitData').val();
    if ($val_gaInitData !== undefined) {
        $.promo.ganalytics.init($.parseJSON($val_gaInitData));
    }
});

