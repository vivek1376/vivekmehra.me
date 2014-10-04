/*! nanoScrollerJS - v0.8.0 - (c) 2014 James Florentino; Licensed MIT */

!function (a, b, c) {
    "use strict";
    var d, e, f, g, h, i, j, k, l, m, n, o, p, q, r, s, t, u, v, w, x, y, z, A, B, C, D, E, F;
    x = {paneClass: "nano-pane", sliderClass: "nano-slider", contentClass: "nano-content", iOSNativeScrolling: !1, preventPageScrolling: !1, disableResize: !1, alwaysVisible: !1, flashDelay: 1500, sliderMinHeight: 20, sliderMaxHeight: null, documentContext: null, windowContext: null}, s = "scrollbar", r = "scroll", k = "mousedown", l = "mousemove", n = "mousewheel", m = "mouseup", q = "resize", h = "drag", u = "up", p = "panedown", f = "DOMMouseScroll", g = "down", v = "wheel", i = "keydown", j = "keyup", t = "touchmove", d = "Microsoft Internet Explorer" === b.navigator.appName && /msie 7./i.test(b.navigator.appVersion) && b.ActiveXObject, e = null, B = b.requestAnimationFrame, w = b.cancelAnimationFrame, D = c.createElement("div").style, F = function () {
        var a, b, c, d, e, f;
        for (d = ["t", "webkitT", "MozT", "msT", "OT"], a = e = 0, f = d.length; f > e; a = ++e)if (c = d[a], b = d[a] + "ransform", b in D)return d[a].substr(0, d[a].length - 1);
        return!1
    }(), E = function (a) {
        return F === !1 ? !1 : "" === F ? a : F + a.charAt(0).toUpperCase() + a.substr(1)
    }, C = E("transform"), z = C !== !1, y = function () {
        var a, b, d;
        return a = c.createElement("div"), b = a.style, b.position = "absolute", b.width = "100px", b.height = "100px", b.overflow = r, b.top = "-9999px", c.body.appendChild(a), d = a.offsetWidth - a.clientWidth, c.body.removeChild(a), d
    }, A = function () {
        var a, c, d;
        return c = b.navigator.userAgent, (a = /(?=.+Mac OS X)(?=.+Firefox)/.test(c)) ? (d = /Firefox\/\d{2}\./.exec(c), d && (d = d[0].replace(/\D+/g, "")), a && +d > 23) : !1
    }, o = function () {
        function i(d, f) {
            this.el = d, this.options = f, e || (e = y()), this.$el = a(this.el), this.doc = a(this.options.documentContext || c), this.win = a(this.options.windowContext || b), this.$content = this.$el.children("." + f.contentClass), this.$content.attr("tabindex", this.options.tabIndex || 0), this.content = this.$content[0], this.previousPosition = 0, this.options.iOSNativeScrolling && null != this.el.style.WebkitOverflowScrolling ? this.nativeScrolling() : this.generate(), this.createEvents(), this.addEvents(), this.reset()
        }

        return i.prototype.preventScrolling = function (a, b) {
            if (this.isActive)if (a.type === f)(b === g && a.originalEvent.detail > 0 || b === u && a.originalEvent.detail < 0) && a.preventDefault(); else if (a.type === n) {
                if (!a.originalEvent || !a.originalEvent.wheelDelta)return;
                (b === g && a.originalEvent.wheelDelta < 0 || b === u && a.originalEvent.wheelDelta > 0) && a.preventDefault()
            }
        }, i.prototype.nativeScrolling = function () {
            this.$content.css({WebkitOverflowScrolling: "touch"}), this.iOSNativeScrolling = !0, this.isActive = !0
        }, i.prototype.updateScrollValues = function () {
            var a, b;
            a = this.content, this.maxScrollTop = a.scrollHeight - a.clientHeight, this.prevScrollTop = this.contentScrollTop || 0, this.contentScrollTop = a.scrollTop, b = this.contentScrollTop > this.previousPosition ? "down" : this.contentScrollTop < this.previousPosition ? "up" : "same", this.previousPosition = this.contentScrollTop, "same" !== b && this.$el.trigger("update", {position: this.contentScrollTop, maximum: this.maxScrollTop, direction: b}), this.iOSNativeScrolling || (this.maxSliderTop = this.paneHeight - this.sliderHeight, this.sliderTop = 0 === this.maxScrollTop ? 0 : this.contentScrollTop * this.maxSliderTop / this.maxScrollTop)
        }, i.prototype.setOnScrollStyles = function () {
            var a;
            z ? (a = {}, a[C] = "translate(0, " + this.sliderTop + "px)") : a = {top: this.sliderTop}, B ? this.scrollRAF || (this.scrollRAF = B(function (b) {
                return function () {
                    b.scrollRAF = null, b.slider.css(a)
                }
            }(this))) : this.slider.css(a)
        }, i.prototype.createEvents = function () {
            this.events = {down: function (a) {
                return function (b) {
                    return a.isBeingDragged = !0, a.offsetY = b.pageY - a.slider.offset().top, a.pane.addClass("active"), a.doc.bind(l, a.events[h]).bind(m, a.events[u]), !1
                }
            }(this), drag: function (a) {
                return function (b) {
                    return a.sliderY = b.pageY - a.$el.offset().top - a.offsetY, a.scroll(), a.contentScrollTop >= a.maxScrollTop && a.prevScrollTop !== a.maxScrollTop ? a.$el.trigger("scrollend") : 0 === a.contentScrollTop && 0 !== a.prevScrollTop && a.$el.trigger("scrolltop"), !1
                }
            }(this), up: function (a) {
                return function () {
                    return a.isBeingDragged = !1, a.pane.removeClass("active"), a.doc.unbind(l, a.events[h]).unbind(m, a.events[u]), !1
                }
            }(this), resize: function (a) {
                return function () {
                    a.reset()
                }
            }(this), panedown: function (a) {
                return function (b) {
                    return a.sliderY = (b.offsetY || b.originalEvent.layerY) - .5 * a.sliderHeight, a.scroll(), a.events.down(b), !1
                }
            }(this), scroll: function (a) {
                return function (b) {
                    a.updateScrollValues(), a.isBeingDragged || (a.iOSNativeScrolling || (a.sliderY = a.sliderTop, a.setOnScrollStyles()), null != b && (a.contentScrollTop >= a.maxScrollTop ? (a.options.preventPageScrolling && a.preventScrolling(b, g), a.prevScrollTop !== a.maxScrollTop && a.$el.trigger("scrollend")) : 0 === a.contentScrollTop && (a.options.preventPageScrolling && a.preventScrolling(b, u), 0 !== a.prevScrollTop && a.$el.trigger("scrolltop"))))
                }
            }(this), wheel: function (a) {
                return function (b) {
                    var c;
                    if (null != b)return c = b.delta || b.wheelDelta || b.originalEvent && b.originalEvent.wheelDelta || -b.detail || b.originalEvent && -b.originalEvent.detail, c && (a.sliderY += -c / 3), a.scroll(), !1
                }
            }(this)}
        }, i.prototype.addEvents = function () {
            var a;
            this.removeEvents(), a = this.events, this.options.disableResize || this.win.bind(q, a[q]), this.iOSNativeScrolling || (this.slider.bind(k, a[g]), this.pane.bind(k, a[p]).bind("" + n + " " + f, a[v])), this.$content.bind("" + r + " " + n + " " + f + " " + t, a[r])
        }, i.prototype.removeEvents = function () {
            var a;
            a = this.events, this.win.unbind(q, a[q]), this.iOSNativeScrolling || (this.slider.unbind(), this.pane.unbind()), this.$content.unbind("" + r + " " + n + " " + f + " " + t, a[r])
        }, i.prototype.generate = function () {
            var a, c, d, f, g, h, i;
            return f = this.options, h = f.paneClass, i = f.sliderClass, a = f.contentClass, (g = this.$el.children("." + h)).length || g.children("." + i).length || this.$el.append('<div class="' + h + '"><div class="' + i + '" /></div>'), this.pane = this.$el.children("." + h), this.slider = this.pane.find("." + i), 0 === e && A() ? (d = b.getComputedStyle(this.content, null).getPropertyValue("padding-right").replace(/\D+/g, ""), c = {right: -14, paddingRight: +d + 14}) : e && (c = {right: -e}, this.$el.addClass("has-scrollbar")), null != c && this.$content.css(c), this
        }, i.prototype.restore = function () {
            this.stopped = !1, this.iOSNativeScrolling || this.pane.show(), this.addEvents()
        }, i.prototype.reset = function () {
            var a, b, c, f, g, h, i, j, k, l, m, n;
            return this.iOSNativeScrolling ? void(this.contentHeight = this.content.scrollHeight) : (this.$el.find("." + this.options.paneClass).length || this.generate().stop(), this.stopped && this.restore(), a = this.content, f = a.style, g = f.overflowY, d && this.$content.css({height: this.$content.height()}), b = a.scrollHeight + e, l = parseInt(this.$el.css("max-height"), 10), l > 0 && (this.$el.height(""), this.$el.height(a.scrollHeight > l ? l : a.scrollHeight)), i = this.pane.outerHeight(!1), k = parseInt(this.pane.css("top"), 10), h = parseInt(this.pane.css("bottom"), 10), j = i + k + h, n = Math.round(j / b * j), n < this.options.sliderMinHeight ? n = this.options.sliderMinHeight : null != this.options.sliderMaxHeight && n > this.options.sliderMaxHeight && (n = this.options.sliderMaxHeight), g === r && f.overflowX !== r && (n += e), this.maxSliderTop = j - n, this.contentHeight = b, this.paneHeight = i, this.paneOuterHeight = j, this.sliderHeight = n, this.slider.height(n), this.events.scroll(), this.pane.show(), this.isActive = !0, a.scrollHeight === a.clientHeight || this.pane.outerHeight(!0) >= a.scrollHeight && g !== r ? (this.pane.hide(), this.isActive = !1) : this.el.clientHeight === a.scrollHeight && g === r ? this.slider.hide() : this.slider.show(), this.pane.css({opacity: this.options.alwaysVisible ? 1 : "", visibility: this.options.alwaysVisible ? "visible" : ""}), c = this.$content.css("position"), ("static" === c || "relative" === c) && (m = parseInt(this.$content.css("right"), 10), m && this.$content.css({right: "", marginRight: m})), this)
        }, i.prototype.scroll = function () {
            return this.isActive ? (this.sliderY = Math.max(0, this.sliderY), this.sliderY = Math.min(this.maxSliderTop, this.sliderY), this.$content.scrollTop((this.paneHeight - this.contentHeight + e) * this.sliderY / this.maxSliderTop * -1), this.iOSNativeScrolling || (this.updateScrollValues(), this.setOnScrollStyles()), this) : void 0
        }, i.prototype.scrollBottom = function (a) {
            return this.isActive ? (this.$content.scrollTop(this.contentHeight - this.$content.height() - a).trigger(n), this.stop().restore(), this) : void 0
        }, i.prototype.scrollTop = function (a) {
            return this.isActive ? (this.$content.scrollTop(+a).trigger(n), this.stop().restore(), this) : void 0
        }, i.prototype.scrollTo = function (a) {
            return this.isActive ? (this.scrollTop(this.$el.find(a).get(0).offsetTop), this) : void 0
        }, i.prototype.stop = function () {
            return w && this.scrollRAF && (w(this.scrollRAF), this.scrollRAF = null), this.stopped = !0, this.removeEvents(), this.iOSNativeScrolling || this.pane.hide(), this
        }, i.prototype.destroy = function () {
            return this.stopped || this.stop(), !this.iOSNativeScrolling && this.pane.length && this.pane.remove(), d && this.$content.height(""), this.$content.removeAttr("tabindex"), this.$el.hasClass("has-scrollbar") && (this.$el.removeClass("has-scrollbar"), this.$content.css({right: ""})), this
        }, i.prototype.flash = function () {
            return!this.iOSNativeScrolling && this.isActive ? (this.reset(), this.pane.addClass("flashed"), setTimeout(function (a) {
                return function () {
                    a.pane.removeClass("flashed")
                }
            }(this), this.options.flashDelay), this) : void 0
        }, i
    }(), a.fn.nanoScroller = function (b) {
        return this.each(function () {
            var c, d;
            if ((d = this.nanoscroller) || (c = a.extend({}, x, b), this.nanoscroller = d = new o(this, c)), b && "object" == typeof b) {
                if (a.extend(d.options, b), null != b.scrollBottom)return d.scrollBottom(b.scrollBottom);
                if (null != b.scrollTop)return d.scrollTop(b.scrollTop);
                if (b.scrollTo)return d.scrollTo(b.scrollTo);
                if ("bottom" === b.scroll)return d.scrollBottom(0);
                if ("top" === b.scroll)return d.scrollTop(0);
                if (b.scroll && b.scroll instanceof a)return d.scrollTo(b.scroll);
                if (b.stop)return d.stop();
                if (b.destroy)return d.destroy();
                if (b.flash)return d.flash()
            }
            return d.reset()
        })
    }, a.fn.nanoScroller.Constructor = o
}(jQuery, window, document);
//# sourceMappingURL=jquery.nanoscroller.min.map
