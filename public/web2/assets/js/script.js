(function ($) {
    "use strict";

    // ===Datepicker===
    if ($("#datepicker").length) {
        $("#datepicker").datepicker();
    }

    // ===Price Filter===
    function priceFilter() {
        if ($(".price-ranger").length) {
            $(".price-ranger #slider-range").slider({
                range: true,
                min: 0,
                max: 5000,
                values: [0, 3000],
                slide: function (event, ui) {
                    $(".price-ranger .ranger-min-max-block .min").val("" + ui.values[0]);
                    $(".price-ranger .ranger-min-max-block .max").val("" + ui.values[1]);
                },
            });
            $(".price-ranger .ranger-min-max-block .min").val(
                "" + $(".price-ranger #slider-range").slider("values", 0)
            );
            $(".price-ranger .ranger-min-max-block .max").val(
                "" + $(".price-ranger #slider-range").slider("values", 1)
            );
        }
    }

    // ===Quantity Btn===
    $(".add").on("click", function () {
        if ($(this).prev().val() < 999) {
            $(this)
                .prev()
                .val(+$(this).prev().val() + 1);
        }
    });
    $(".sub").on("click", function () {
        if ($(this).next().val() > 1) {
            if ($(this).next().val() > 1)
                $(this)
                    .next()
                    .val(+$(this).next().val() - 1);
        }
    });

    // ===Checkout Payment===
    if ($(".checkout__payment__title").length) {
        $(".checkout__payment__item").find(".checkout__payment__content").hide();
        $(".checkout__payment__item--active").find(".checkout__payment__content").show();

        $(".checkout__payment__title").on("click", function (e) {
            e.preventDefault();

            $(this)
                .parents(".checkout__payment")
                .find(".checkout__payment__item")
                .removeClass("checkout__payment__item--active");
            $(this).parents(".checkout__payment").find(".checkout__payment__content").slideUp();

            $(this).parent().addClass("checkout__payment__item--active");
            $(this).parent().find(".checkout__payment__content").slideDown();
        });
    }

    //Image Reveal Animation
    if ($(".reveal").length) {
        gsap.registerPlugin(ScrollTrigger);
        let revealContainers = document.querySelectorAll(".reveal");
        revealContainers.forEach((container) => {
            let image = container.querySelector("img");
            let tl = gsap.timeline({
                scrollTrigger: {
                    trigger: container,
                    toggleActions: "play none none none",
                },
            });
            tl.set(container, {
                autoAlpha: 1,
            });
            tl.from(container, 1.5, {
                xPercent: -100,
                ease: Power2.out,
            });
            tl.from(image, 1.5, {
                xPercent: 100,
                scale: 1.3,
                delay: -1.5,
                ease: Power2.out,
            });
        });
    }

    // ===Main Slider / Banner Carousel===
    if ($(".slider-one__carousel").length) {
        $(".slider-one__carousel").owlCarousel({
            loop: true,
            animateOut: "fadeOut",
            animateIn: "fadeIn",
            margin: 0,
            nav: true,
            dots: false,
            smartSpeed: 500,
            autoplay: true,
            autoplayTimeout: 7000,
            navText: [
                '<span class="icon-right-arrow2"></span>',
                '<span class="icon-right-arrow21"></span>',
            ],
            responsive: {
                0: {
                    items: 1,
                },
                600: {
                    items: 1,
                },
                800: {
                    items: 1,
                },
                992: {
                    items: 1,
                },
            },
        });
    }

    //Brand One Carousel
    if ($(".brand-one__carousel").length) {
        $(".brand-one__carousel").owlCarousel({
            loop: true,
            margin: 0,
            nav: false,
            dots: false,
            smartSpeed: 500,
            autoplay: true,
            autoplayTimeout: 7000,
            navText: [
                '<span class="icon-left-arrow"></span>',
                '<span class="icon-left-arrow right-arrow"></span>',
            ],
            responsive: {
                0: {
                    items: 2,
                },
                768: {
                    items: 3,
                },
                992: {
                    items: 4,
                },
                1200: {
                    items: 5,
                },
                1320: {
                    items: 6,
                },
            },
        });
    }

    //Testimonial One Carousel
    if ($(".testimonial-one__carousel").length) {
        $(".testimonial-one__carousel").owlCarousel({
            loop: true,
            margin: 0,
            nav: false,
            dots: false,
            smartSpeed: 500,
            autoplay: true,
            autoplayTimeout: 7000,
            navText: [
                '<span class="icon-left-arrow"></span>',
                '<span class="icon-right-arrow"></span>',
            ],
            responsive: {
                0: {
                    items: 1,
                },
                768: {
                    items: 1,
                },
                992: {
                    items: 1,
                },
                1200: {
                    items: 1,
                },
                1320: {
                    items: 1,
                },
            },
        });
    }

    //Team One Carousel
    if ($(".team-one__carousel").length) {
        $(".team-one__carousel").owlCarousel({
            loop: true,
            margin: 20,
            nav: false,
            dots: true,
            smartSpeed: 500,
            autoplay: true,
            autoplayTimeout: 7000,
            navText: [
                '<span class="icon-left-arrow"></span>',
                '<span class="icon-right-arrow"></span>',
            ],
            responsive: {
                0: {
                    items: 1,
                },
                768: {
                    items: 2,
                },
                992: {
                    items: 2,
                },
                1200: {
                    items: 3,
                },
                1320: {
                    items: 3,
                },
            },
        });
    }

    //Service One Carousel
    if ($(".service-one__carousel").length) {
        $(".service-one__carousel").owlCarousel({
            loop: true,
            margin: 30,
            nav: false,
            dots: true,
            smartSpeed: 500,
            autoplay: true,
            autoplayTimeout: 7000,
            navText: [
                '<span class="icon-left-arrow"></span>',
                '<span class="icon-right-arrow"></span>',
            ],
            responsive: {
                0: {
                    items: 1,
                },
                768: {
                    items: 2,
                },
                992: {
                    items: 2,
                },
                1200: {
                    items: 3,
                },
                1320: {
                    items: 3,
                },
            },
        });
    }

    //Testimonial Two Carousel
    if ($(".testimonial-two__carousel").length) {
        $(".testimonial-two__carousel").owlCarousel({
            loop: true,
            margin: 20,
            nav: false,
            dots: true,
            smartSpeed: 500,
            autoplay: true,
            autoplayTimeout: 7000,
            navText: [
                '<span class="icon-left-arrow"></span>',
                '<span class="icon-right-arrow"></span>',
            ],
            responsive: {
                0: {
                    items: 1,
                },
                768: {
                    items: 1,
                },
                992: {
                    items: 2,
                },
                1200: {
                    items: 2,
                },
                1320: {
                    items: 2,
                },
            },
        });
    }

    //Testimonial Three Carousel
    if ($(".testimonial-three__carousel").length) {
        $(".testimonial-three__carousel").owlCarousel({
            loop: true,
            margin: 0,
            nav: true,
            dots: false,
            smartSpeed: 500,
            autoplay: true,
            autoplayTimeout: 7000,
            navText: [
                '<span class="icon-right-arrow2"></span>',
                '<span class="icon-right-arrow21"></span>',
            ],
            responsive: {
                0: {
                    items: 1,
                },
                768: {
                    items: 1,
                },
                992: {
                    items: 1,
                },
                1200: {
                    items: 1,
                },
                1320: {
                    items: 1,
                },
            },
        });
    }

    //Service Two Carousel
    if ($(".service-two__carousel").length) {
        $(".service-two__carousel").owlCarousel({
            loop: true,
            margin: 30,
            nav: false,
            dots: true,
            smartSpeed: 500,
            autoplay: true,
            autoplayTimeout: 7000,
            navText: [
                '<span class="icon-left-arrow"></span>',
                '<span class="icon-right-arrow"></span>',
            ],
            responsive: {
                0: {
                    items: 1,
                },
                768: {
                    items: 2,
                },
                992: {
                    items: 2,
                },
                1200: {
                    items: 3,
                },
                1320: {
                    items: 3,
                },
            },
        });
    }

    // Quote One Tab
    if ($(".quote-tab").length) {
        $(".quote-tab .tabs-button-box .tab-btn-item").on("click", function (e) {
            e.preventDefault();
            var target = $($(this).attr("data-tab"));

            if ($(target).hasClass("actve-tab")) {
                return false;
            } else {
                $(".quote-tab .tabs-button-box .tab-btn-item").removeClass("active-btn-item");
                $(this).addClass("active-btn-item");
                $(".quote-tab .tabs-content-box .tab-content-box-item").removeClass(
                    "tab-content-box-item-active"
                );
                $(target).addClass("tab-content-box-item-active");
            }
        });
    }

    //Progress Count Bar
    if ($(".count-bar").length) {
        $(".count-bar").appear(
            function () {
                var el = $(this);
                var percent = el.data("percent");
                $(el).css("width", percent).addClass("counted");
            },
            {
                accY: -50,
            }
        );
    }

    //Progress Bar / Levels
    if ($(".progress-levels .progress-box .bar-fill").length) {
        $(".progress-box .bar-fill").each(
            function () {
                $(".progress-box .bar-fill").appear(function () {
                    var progressWidth = $(this).attr("data-percent");
                    $(this).css("width", progressWidth + "%");
                });
            },
            {
                accY: 0,
            }
        );
    }

    //Fact Counter + Text Count
    if ($(".count-box").length) {
        $(".count-box").appear(
            function () {
                var $t = $(this),
                    n = $t.find(".count-text").attr("data-stop"),
                    r = parseInt($t.find(".count-text").attr("data-speed"), 10);

                if (!$t.hasClass("counted")) {
                    $t.addClass("counted");
                    $({
                        countNum: $t.find(".count-text").text(),
                    }).animate(
                        {
                            countNum: n,
                        },
                        {
                            duration: r,
                            easing: "linear",
                            step: function () {
                                $t.find(".count-text").text(Math.floor(this.countNum));
                            },
                            complete: function () {
                                $t.find(".count-text").text(this.countNum);
                            },
                        }
                    );
                }
            },
            {
                accY: 0,
            }
        );
    }

    // Accrodion
    if ($(".accrodion-grp").length) {
        var accrodionGrp = $(".accrodion-grp");
        accrodionGrp.each(function () {
            var accrodionName = $(this).data("grp-name");
            var Self = $(this);
            var accordion = Self.find(".accrodion");
            Self.addClass(accrodionName);
            Self.find(".accrodion .accrodion-content").hide();
            Self.find(".accrodion.active").find(".accrodion-content").show();
            accordion.each(function () {
                $(this)
                    .find(".accrodion-title")
                    .on("click", function () {
                        if ($(this).parent().hasClass("active") === false) {
                            $(".accrodion-grp." + accrodionName)
                                .find(".accrodion")
                                .removeClass("active");
                            $(".accrodion-grp." + accrodionName)
                                .find(".accrodion")
                                .find(".accrodion-content")
                                .slideUp();
                            $(this).parent().addClass("active");
                            $(this).parent().find(".accrodion-content").slideDown();
                        }
                    });
            });
        });
    }

    if ($(".contact-form-validated").length) {
        $(".contact-form-validated").each(function () {
            let self = $(this);
            self.validate({
                // initialize the plugin
                rules: {
                    name: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    message: {
                        required: true,
                    },
                    subject: {
                        required: true,
                    },
                },
                submitHandler: function (form) {
                    // sending value with ajax request
                    $.post($(form).attr("action"), $(form).serialize(), function (response) {
                        $(form).parent().find(".result").append(response);
                        $(form).find('input[type="text"]').val("");
                        $(form).find('input[type="email"]').val("");
                        $(form).find("textarea").val("");
                    });
                    return false;
                },
            });
        });
    }

    if ($(".video-popup").length) {
        $(".video-popup").magnificPopup({
            type: "iframe",
            mainClass: "mfp-fade",
            removalDelay: 160,
            preloader: true,

            fixedContentPos: false,
        });
    }

    if ($(".img-popup").length) {
        var groups = {};
        $(".img-popup").each(function () {
            var id = parseInt($(this).attr("data-group"), 10);

            if (!groups[id]) {
                groups[id] = [];
            }

            groups[id].push(this);
        });

        $.each(groups, function () {
            $(this).magnificPopup({
                type: "image",
                closeOnContentClick: true,
                closeBtnInside: false,
                gallery: {
                    enabled: true,
                },
            });
        });
    }

    function dynamicCurrentMenuClass(selector) {
        let FileName = window.location.href.split("/").reverse()[0];

        selector.find("li").each(function () {
            let anchor = $(this).find("a");
            if ($(anchor).attr("href") == FileName) {
                $(this).addClass("current");
            }
        });
        // if any li has .current elmnt add class
        selector.children("li").each(function () {
            if ($(this).find(".current").length) {
                $(this).addClass("current");
            }
        });
        // if no file name return
        if ("" == FileName) {
            selector.find("li").eq(0).addClass("current");
        }
    }

    if ($(".main-menu__list").length) {
        // dynamic current class
        let mainNavUL = $(".main-menu__list");
        dynamicCurrentMenuClass(mainNavUL);
    }

    if ($(".main-menu__list").length && $(".mobile-nav__container").length) {
        let navContent = document.querySelector(".main-menu__list").outerHTML;
        let mobileNavContainer = document.querySelector(".mobile-nav__container");
        mobileNavContainer.innerHTML = navContent;
    }

    if ($(".sticky-header__content").length) {
        let navContent = document.querySelector(".main-menu").innerHTML;
        let mobileNavContainer = document.querySelector(".sticky-header__content");
        mobileNavContainer.innerHTML = navContent;
    }

    if ($(".mobile-nav__container .main-menu__list").length) {
        let dropdownAnchor = $(".mobile-nav__container .main-menu__list .dropdown > a");
        dropdownAnchor.each(function () {
            let self = $(this);
            let toggleBtn = document.createElement("BUTTON");
            toggleBtn.setAttribute("aria-label", "dropdown toggler");
            toggleBtn.innerHTML = "<i class='fa fa-angle-down'></i>";
            self.append(function () {
                return toggleBtn;
            });
            self.find("button").on("click", function (e) {
                e.preventDefault();
                let self = $(this);
                self.toggleClass("expanded");
                self.parent().toggleClass("expanded");
                self.parent().parent().children("ul").slideToggle();
            });
        });
    }

    if ($(".mobile-nav__toggler").length) {
        $(".mobile-nav__toggler").on("click", function (e) {
            e.preventDefault();
            $(".mobile-nav__wrapper").toggleClass("expanded");
            $("body").toggleClass("locked");
        });
    }

    if ($(".search-toggler").length) {
        $(".search-toggler").on("click", function (e) {
            e.preventDefault();
            $(".search-popup").toggleClass("active");
            $(".mobile-nav__wrapper").removeClass("expanded");
            $("body").toggleClass("locked");
        });
    }

    if ($(".odometer").length) {
        var odo = $(".odometer");
        odo.each(function () {
            $(this).appear(function () {
                var countNumber = $(this).attr("data-count");
                $(this).html(countNumber);
            });
        });
    }

    if ($(".wow").length) {
        var wow = new WOW({
            boxClass: "wow", // animated element css class (default is wow)
            animateClass: "animated", // animation css class (default is animated)
            mobile: true, // trigger animations on mobile devices (default is true)
            live: true, // act on asynchronously loaded content (default is true)
        });
        wow.init();
    }

    if ($(".tabs-box").length) {
        $(".tabs-box .tab-buttons .tab-btn").on("click", function (e) {
            e.preventDefault();
            var target = $($(this).attr("data-tab"));

            if ($(target).is(":visible")) {
                return false;
            } else {
                target
                    .parents(".tabs-box")
                    .find(".tab-buttons")
                    .find(".tab-btn")
                    .removeClass("active-btn");
                $(this).addClass("active-btn");
                target.parents(".tabs-box").find(".tabs-content").find(".tab").fadeOut(0);
                target
                    .parents(".tabs-box")
                    .find(".tabs-content")
                    .find(".tab")
                    .removeClass("active-tab");
                $(target).fadeIn(300);
                $(target).addClass("active-tab");
            }
        });
    }

    function SmoothMenuScroll() {
        var anchor = $(".scrollToLink");
        if (anchor.length) {
            anchor.children("a").bind("click", function (event) {
                if ($(window).scrollTop() > 10) {
                    var headerH = "90";
                } else {
                    var headerH = "90";
                }
                var target = $(this);
                $("html, body")
                    .stop()
                    .animate(
                        {
                            scrollTop: $(target.attr("href")).offset().top - headerH + "px",
                        },
                        1200,
                        "easeInOutExpo"
                    );
                anchor.removeClass("current");
                anchor.removeClass("current-menu-ancestor");
                anchor.removeClass("current_page_item");
                anchor.removeClass("current-menu-parent");
                target.parent().addClass("current");
                event.preventDefault();
            });
        }
    }
    SmoothMenuScroll();

    function OnePageMenuScroll() {
        var windscroll = $(window).scrollTop();
        if (windscroll >= 117) {
            var menuAnchor = $(".one-page-scroll-menu .scrollToLink").children("a");
            menuAnchor.each(function () {
                var sections = $(this).attr("href");
                $(sections).each(function () {
                    if ($(this).offset().top <= windscroll + 100) {
                        var Sectionid = $(sections).attr("id");
                        $(".one-page-scroll-menu").find("li").removeClass("current");
                        $(".one-page-scroll-menu").find("li").removeClass("current-menu-ancestor");
                        $(".one-page-scroll-menu").find("li").removeClass("current_page_item");
                        $(".one-page-scroll-menu").find("li").removeClass("current-menu-parent");
                        $(".one-page-scroll-menu")
                            .find("a[href*=\\#" + Sectionid + "]")
                            .parent()
                            .addClass("current");
                    }
                });
            });
        } else {
            $(".one-page-scroll-menu li.current").removeClass("current");
            $(".one-page-scroll-menu li:first").addClass("current");
        }
    }

    /*-- Handle Scrollbar --*/
    function handleScrollbar() {
        const bodyHeight = $("body").height();
        const scrollPos = $(window).innerHeight() + $(window).scrollTop();
        let percentage = (scrollPos / bodyHeight) * 100;
        if (percentage > 100) {
            percentage = 100;
        }
        $(".scroll-to-top .scroll-to-top__inner").css("width", percentage + "%");
    }

    // window load event
    $(window).on("load", function () {
        function handlePreloader() {
            if ($(".loader-wrap").length) {
                $(".loader-wrap").delay(500).fadeOut(500);
            }
        }

        if ($(".preloader-close").length) {
            $(".preloader-close").on("click", function () {
                $(".loader-wrap").delay(200).fadeOut(500);
            });
        }

        priceFilter();
        tg_title_animation();
        handlePreloader();

        // Curved Circle
        if ($(".about-one__curved-circle").length) {
            $(".about-one__curved-circle").circleType({
                position: "absolute",
                dir: 1,
                radius: 75,
                forceHeight: true,
                forceWidth: true,
            });
        }

        if ($(".curved-circle").length) {
            $(".curved-circle").circleType({
                position: "absolute",
                dir: 1,
                radius: 90,
                forceHeight: true,
                forceWidth: true,
            });
        }
    });

    // window scroll event
    $(window).on("scroll", function () {
        if ($(".stricked-menu").length) {
            var headerScrollPos = 130;
            var stricky = $(".stricked-menu");
            if ($(window).scrollTop() > headerScrollPos) {
                stricky.addClass("stricky-fixed");
            } else if ($(this).scrollTop() <= headerScrollPos) {
                stricky.removeClass("stricky-fixed");
            }
        }

        OnePageMenuScroll();
    });

    $(window).on("scroll", function () {
        handleScrollbar();
        if ($(".sticky-header--one-page").length) {
            var headerScrollPos = 120;
            var stricky = $(".sticky-header--one-page");
            if ($(window).scrollTop() > headerScrollPos) {
                stricky.addClass("active");
            } else if ($(this).scrollTop() <= headerScrollPos) {
                stricky.removeClass("active");
            }
        }

        var scrollToTopBtn = ".scroll-to-top";
        if (scrollToTopBtn.length) {
            if ($(window).scrollTop() > 500) {
                $(scrollToTopBtn).addClass("show");
            } else {
                $(scrollToTopBtn).removeClass("show");
            }
        }
    });

    /*=============================================
        Tg Title Animation	      
    =============================================*/

    gsap.registerPlugin(ScrollTrigger, SplitText);
    gsap.config({
        nullTargetWarn: false,
        trialWarn: false,
    });

    function tg_title_animation() {
        var tg_var = jQuery(".tg-heading-subheading");
        if (!tg_var.length) {
            return;
        }
        const quotes = document.querySelectorAll(".tg-heading-subheading .tg-element-title");

        quotes.forEach((quote) => {
            //Reset if needed
            if (quote.animation) {
                quote.animation.progress(1).kill();
                quote.split.revert();
            }

            var getclass = quote.closest(".tg-heading-subheading").className;
            var animation = getclass.split("animation-");
            if (animation[1] == "style4") return;

            quote.split = new SplitText(quote, {
                type: "lines,words,chars",
                linesClass: "split-line",
            });
            gsap.set(quote, {
                perspective: 400,
            });

            if (animation[1] == "style1") {
                gsap.set(quote.split.chars, {
                    opacity: 0,
                    y: "90%",
                    rotateX: "-40deg",
                });
            }
            if (animation[1] == "style2") {
                gsap.set(quote.split.chars, {
                    opacity: 0,
                    x: "50",
                });
            }
            if (animation[1] == "style3") {
                gsap.set(quote.split.chars, {
                    opacity: 0,
                });
            }
            quote.animation = gsap.to(quote.split.chars, {
                scrollTrigger: {
                    trigger: quote,
                    start: "top 90%",
                },
                x: "0",
                y: "0",
                rotateX: "0",
                opacity: 1,
                duration: 1,
                ease: Back.easeOut,
                stagger: 0.02,
            });
        });
    }
    ScrollTrigger.addEventListener("refresh", tg_title_animation);

    $("select:not(.ignore)").niceSelect();

    if ($(".marquee_mode").length) {
        $(".marquee_mode").marquee({
            speed: 30,
            gap: 0,
            delayBeforeStart: 0,
            direction: "left",
            duplicated: true,
            pauseOnHover: true,
            startVisible: true,
        });
    }
})(jQuery);
