  jQuery(document).ready(function () {
        jQuery(".add").click(function () {
            jQuery("#xianzhi").append("<div class=\"mulu\"><input type=\"text\" class=\"input\" ref=\"xianzhi\"/></div>");
        })
        jQuery(".addsite").click(function () {
            jQuery("#sitemap").append("<div class=\"mulu\"><input type=\"text\" class=\"input\" ref=\"sitemap\"/></div>");
        })
        jQuery("#clear").click(function () {
            jQuery(".HJtxt").val('');
        })
        jQuery("#create").click(function () {
            var text = "# robots.txt generated at http://foxzld.com/ \n";
            if (jQuery("#baidu").val() != "") { text += "User-agent: Baiduspider\nDisallow:" + jQuery("#baidu").val() + "\n"; };
            if (jQuery("#soso").val() != "") { text += "User-agent: Sosospider\nDisallow:" + jQuery("#soso").val() + "\n"; }
            if (jQuery("#sogou").val() != "") { text += "User-agent: sogou spider\nDisallow:" + jQuery("#sogou").val() + "\n"; };
            if (jQuery("#youdao").val() != "") { text += "User-agent: YodaoBot\nDisallow:" + jQuery("#youdao").val() + "\n"; }
            if (jQuery("#google").val() != "") { text += "User-agent: Googlebot\nDisallow:" + jQuery("#google").val() + "\n"; };
            if (jQuery("#bing").val() != "") { text += "User-agent: Bingbot\nDisallow:" + jQuery("#bing").val() + "\n"; }
            if (jQuery("#yahoo").val() != "") { text += "User-agent: Slurp\nDisallow:" + jQuery("#yahoo").val() + "\n"; };
            if (jQuery("#ask").val() != "") { text += "User-agent: Teoma\nDisallow:" + jQuery("#ask").val() + "\n"; }
            if (jQuery("#alexa").val() != "") { text += "User-agent: ia_archiver\nDisallow:" + jQuery("#alexa").val() + "\n"; };
            if (jQuery("#cuil").val() != "") { text += "User-agent: twiceler\nDisallow:" + jQuery("#cuil").val() + "\n"; }
            if (jQuery("#msn").val() != "") { text += "User-agent: MSNBot\nDisallow:" + jQuery("#msn").val() + "\n"; };
            if (jQuery("#scrub").val() != "") { text += "User-agent: Scrubby\nDisallow:" + jQuery("#scrub").val() + "\n"; }
            if (jQuery("#dmoz").val() != "") { text += "User-agent: Robozilla\nDisallow:" + jQuery("#dmoz").val() + "\n"; };
            if (jQuery("#giga").val() != "") { text += "User-agent: Gigabot\nDisallow:" + jQuery("#giga").val() + "\n"; }
            if (jQuery("#googleimage").val() != "") { text += "User-agent: googlebot-image\nDisallow:" + jQuery("#googleimage").val() + "\n"; };
            if (jQuery("#googlemobile").val() != "") { text += "User-agent: googlebot-mobile\nDisallow:" + jQuery("#googlemobile").val() + "\n"; }
            if (jQuery("#yahoomm").val() != "") { text += "User-agent: yahoo-mmcrawler\nDisallow:" + jQuery("#yahoomm").val() + "\n"; }
            if (jQuery("#yahooblogs").val() != "") { text += "User-agent: yahoo-blogs/v3.9\nDisallow:" + jQuery("#yahooblogs").val() + "\n"; };
            if (jQuery("#msnpic").val() != "") { text += "User-agent: psbot\nDisallow:" + jQuery("#msnpic").val() + "\n"; }
            if (jQuery("#all").val() != "") { text += "User-agent: *\nDisallow:" + jQuery("#all").val() + "\n"; }
            if (jQuery("#delay").val() != "") { text += "Crawl-delay: " + jQuery("#delay").val() + "\n"; }
            jQuery('#xianzhi input[ref="xianzhi"]').each(function(){if(jQuery(this).val()!=""){ text += "Disallow: " +jQuery(this).val() + "\n"; }});
            jQuery('#sitemap input[ref="sitemap"]').each(function(){if(jQuery(this).val()!=""){text+="Sitemap: "+jQuery(this).val()+"\n";}});
            jQuery(".HJtxt").val(text);
           
        })
    })