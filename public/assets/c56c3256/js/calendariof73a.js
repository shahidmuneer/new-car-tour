exCalendario = {
    params: {
        trackId : 0,
        hasPrivateEvents : 0,
        eventsUrl : [],
        availableMsg : '',
    },
    wrapper: $('#calendario-inner'),
    calendar: $('#calendar'),
    cal: null,
    month: null,
    year: null,
    init : function(params) {
        var self = this;
        self.params = params
        self.cal = self.calendar.calendario({
            onDayClick : function($el, data, dateProperties) {
                if (data.content.length > 0) {
                    self.showEvents(data.content, dateProperties);
                } else if (self.calendar.hasClass('private') && $el.hasClass('fc-future')) {
                    self.showEvents(['<a href="' + self.params.eventsUrl[self.params.trackId == 6 ? self.params.trackId : 0] + '" class="corporate">' + self.params.availableMsg + '</a>'], dateProperties);
                }
            },
            displayWeekAbbr : true,
            events: 'click'
        }),
                
        self.month = $('#calendario-month').html(self.cal.getMonthName()),
        self.year = $('#calendario-year').html(self.cal.getYear());

        $('#calendario-next').on('click', function () {
            self.cal.gotoNextMonth(updateMonthYear);
        });

        $('#calendario-prev').on('click', function () {
            self.cal.gotoPreviousMonth(updateMonthYear);
        });
        
        function updateMonthYear() {
            self.month.html(self.cal.getMonthName());
            self.year.html(self.cal.getYear());
        }

        $('.schedule-tracks .item a').on('click', function(e) {
            e.preventDefault();
            var $el = $(this);
            var trackId;
            $('.block-layer').show();
            if ($el.data('track')) {
                trackId = $el.data('track');
            } else {
                trackId = self.params.trackId;
            }
            self.changeTrack(trackId, $el.data('type'));
            $('.schedule-tracks .item').removeClass('active');
            $el.closest('.item').addClass('active');
        });

        self.changeTrack(self.params.trackId);

        $(document).on('click', '#calendario-content-reveal a', function(event) {
            if ($(this).attr('href') == '#') {
                event.preventDefault();
            }
        });
        
        return self;
    },
    showEvents : function(contentEl, dateProperties) {
        var self = this;
        self.hideEvents();
        var $events = $('<div id="calendario-content-reveal" class="calendario-content-reveal"><h4>Sessions for ' + dateProperties.monthname + ' ' + dateProperties.day + ', ' + dateProperties.year + '</h4></div>'),
            $close = $('<span class="calendario-content-close"></span>').on('click', self.hideEvents);
        $events.append($('<div class="events"></div>').append(contentEl.join('')), $close).insertAfter(self.wrapper);
        setTimeout(function () {
            $events.css('top', '0%');
        }, 25);
    },
    hideEvents : function() {
        var $events = $('#calendario-content-reveal');
        if ($events.length > 0) {
            $events.css('top', '100%');
            $events.remove();
        }
    },
    changeTrack : function(id, type) {
        if (typeof type === 'undefined') {
            type = null;
        }
        var start = new Date(),
            end = new Date(new Date().setFullYear(start.getFullYear() + 2)),
            self = this;
        self.hideEvents();
        $.post('/schedule/trackDate/getTrackDates', {
            track_id: id,
            start:  Math.round(+start.getTime() / 1000),
            end: Math.round(+end.getTime() / 1000),
            type: type
        }, function(data) {
            var params = {};
            self.calendar.removeClass('private');
            var date = null, j = 0, c = 0;
            if (data.length) {
                for(var i in data) {
                    if (date !== data[i].date) {
                        if (+i !== 0) {
                            params[data[i].date] += '</section>';
                        }
                        params[data[i].date] = '<section style="background: none">';
                        date = data[i].date;
                        if (j === c && c !== 0) {
                            params[data[i - 1].date] += '<div class="disabled"></div>';
                        }
                        j = 0; c = 0;
                    }
                    j++;
                    var status = '', cssClass = '', href = '#';
                    if (data[i].racingSeriesId) {
                        if (typeof params[data[i].date] == 'undefined') {
                            params[data[i].date] = '';
                        }
                        params[data[i].date] += '<a class="race" href="/experience/booking/create/race_session_id/' + data[i].racingSeriesId + '" class="btn btn-green decorate">' + data[i].from + ' - ' + data[i].title + '</a>';
                    } else {
                        if (data[i].session_status === 'C') {
                            status = 'Closed';
                            cssClass = 'closed';
                            c++;
                        } else if (data[i].session_status === 'P') {
                            status = 'Open';
                            cssClass = 'partial';
                            href = '/experience/booking/create/session_id/' + data[i].id;
                        } else {
                            status = 'Open';
                            href = '/experience/booking/create/session_id/' + data[i].id;
                        }
                        var text = '<a href="' + href + '" class="' + cssClass + '">' + data[i].from + ' - ' + status + (data[i].slotsLeft !== null && data[i].session_status !== 'C' ? ' (' + data[i].slotsLeft + ' cars left)' : '') + '</a>';
                        if (typeof params[data[i].date] != 'undefined') {
                            params[data[i].date] += text;
                        } else {
                            params[data[i].date] = text;
                        }
                    }
                }
                params[data[i].date] += '</section>';
            }
            self.cal.setData(params, true);
            $('.block-layer').hide();
        }, 'json');
    }
}