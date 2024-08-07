import $ from 'jquery';

// eventuell noch umstellen auf axios 

class Search {
    // Create / Initialize
    constructor() {
        this.addSearchHTML();

        this.openButton = $(".js-search-trigger");
        this.closeButton = $(".search-overlay__close");
        this.searchOverlay = $(".search-overlay");
        this.searchField = $("#search-term");
        this.resultsDiv = $("#search-overlay__results");
        
        this.events();
        
        this.isOverlayOpen = false;
        this.isSpinnerVisible = false;
        this.previousValue;
        this.typingTimer;
    }

    // Events
    events() {
        this.openButton.on("click", this.openOverlay.bind(this));
        this.closeButton.on("click", this.closeOverlay.bind(this));
        $(document).on("keydown", this.keyPressDispatcher.bind(this));
        this.searchField.on("keyup", this.typingLogic.bind(this));
    }

    // Methoden
    typingLogic() {
        if (this.searchField.val() != this.previousValue) {
            clearTimeout(this.typingTimer);

            if (this.searchField.val()) {
                if (!this.isSpinnerVisible) {
                    this.resultsDiv.html('<div class="spinner-loader"></div>');
                    this.isSpinnerVisible = true;
                }
                this.typingTimer = setTimeout(this.getResults.bind(this), 750);
            }
            else {
                this.resultsDiv.html('');
                this.isSpinnerVisible = false;
            }
        }
        
        this.previousValue = this.searchField.val();
    }

    getResults() {
        $.getJSON(esvData.root_url + '/wp-json/club/v1/search?term=' + this.searchField.val(), (results) => {
            this.resultsDiv.html(`
                <div class="row">
                    <div class="one-third">
                        <h2 class="search-overlay__section-title">Allgemeine Ergebnisse</h2>
                        ${results.generalInfo.length ? '<ul class="link-list min-list">' : '<p>Keine Ergebnisse gefunden...</p>'}
                        ${results.generalInfo.map(item => `<li><a href="${item.url}">${item.title}</a> ${item.postType == 'post' ? `by ${item.postAuthor}` : ''}</li>`).join('')}
                        ${results.generalInfo.length ? '</ul>' : ''}
                    </div>
                    <div class="one-third">
                        <h2 class="search-overlay__section-title">Mitglieder</h2>
                        ${results.memberInfo.length ? '<ul class="player-cards">' : `<p>Keine Ergebnisse gefunden. Für alle Mitglieder klicke <a href="${esvData.root_url}/members">hier</a></p>`}
                        ${results.memberInfo.map(item => `
                                <li class="player-card__list-item">
                                    <a class="player-card" href="${item.url}">
                                        <img class="player-card__image" src="${item.portrait}">
                                        <span class="player-card__name">${item.title}</span>
                                    </a>
                                </li>                  
                            `).join('')}
                        ${results.memberInfo.length ? '</ul>' : ''}

                        <h2 class="search-overlay__section-title">Liga</h2>
                        ${results.leagueInfo.length ? '<ul class="link-list min-list">' : `<p>Keine Ergebnisse gefunden. Für alle Ligen klicke <a href="${esvData.root_url}/league">hier</a></p>`}
                        ${results.leagueInfo.map(item => `<li><a href="${item.url}">${item.title}</a></li>`).join('')}
                        ${results.leagueInfo.length ? '</ul>' : ''}
                    </div>
                    <div class="one-third">
                        <h2 class="search-overlay__section-title">Mannschaft</h2>
                        ${results.teamInfo.length ? '<ul class="link-list min-list">' : `<p>Keine Ergebnisse gefunden. Für alle Mannschaften klicke <a href="${esvData.root_url}/teams">hier</a></p>`}
                        ${results.teamInfo.map(item => `<li><a href="${item.url}">${item.title}</a></li>`).join('')}
                        ${results.teamInfo.length ? '</ul>' : ''}

                        <h2 class="search-overlay__section-title">Termine</h2>
                        ${results.eventInfos.length ? '' : `<p>Keine Termine gefunden. Für alle Termine klicke <a href="${esvData.root_url}/events">hier</a></p>`}
                        ${results.eventInfos.map(item => `
                                <div class="event-summary">
                                    <a class="event-summary__date t-center" href="${item.url}">
                                        <span class="event-summary__month">${item.month}</span>
                                        <span class="event-summary__day">${item.day}</span>
                                    </a>
                                    <div class="event-summary__content">
                                        <h5 class="event-summary__title headline headline--tiny"><a href="${item.url}">${item.title}</a></h5>
                                        <p> ${item.description}<a href="${item.url}" class="nu gray">Weiterlesen</a></p>
                                    </div>
                                </div>
                            `).join('')}
                    </div>
                </div>
            `);
            this.isSpinnerVisible = false;
        });
        
    }

    keyPressDispatcher(e) {
        if (e.keyCode == 83 && !this.isOverlayOpen && !$("input, textarea").is(':focus')) {
            this.openOverlay();
        }
        if (e.keyCode == 27 && this.isOverlayOpen) {
            this.closeOverlay();
        }
    }

    openOverlay() {
        this.searchOverlay.addClass("search-overlay--active");
        $("body").addClass("body-no-scroll");
        this.searchField.val('');
        setTimeout(() => this.searchField.trigger("focus"), 301);
        
        this.isOverlayOpen = true;
        return false;
    }

    closeOverlay() {
        this.searchOverlay.removeClass("search-overlay--active");
        $("body").removeClass("body-no-scroll");
        
        this.isOverlayOpen = false;
    }

    addSearchHTML() {
        $("body").append(`
            <div class="search-overlay">
                <div class="search-overlay__top">
                    <div class="container">
                        <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
                        <input type="text" class="search-term" placeholder="Was suchst du" id="search-term" autocomplete="off">
                        <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="container">
                    <div id="search-overlay__results"></div>
                </div>
            </div>    
        `);
    }
}

export default Search