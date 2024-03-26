function Ajax() {
    var http_request = false;
    var parse_xml = false;
    var eval_javascript = false;
	
    Ajax.prototype.OnAnswer = function(Content) {
        alert("Diese Methode bitte überschreiben");
    }

    Ajax.prototype.Request = function(url,data, x_Parse_xml, x_eval_javascript) {
        http_request = false;
        parse_xml = x_Parse_xml;
        eval_javascript = x_eval_javascript;

        if (window.XMLHttpRequest) { // Mozilla, Safari,...
            http_request = new XMLHttpRequest();
        } else if (window.ActiveXObject) { // IE
            try {
                http_request = new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {
                try {
                    http_request = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (e) {}
            }
        }

        if (!http_request) {
            alert('Ende :( Kann keine XMLHTTP-Instanz erzeugen');
            return false;
        }

        var This = this;

        http_request.onreadystatechange = function() {
            This.HandleRequest();
        }

        http_request.open('POST', url, true);
        http_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        http_request.setRequestHeader("Content-length", data.length);
        http_request.setRequestHeader("Connection", "close");
        http_request.send(data);
    }

    Ajax.prototype.HandleRequest = function() {
        if (http_request.readyState == 4) {
            if (http_request.status == 200) {
                if(!parse_xml)
                    this.OnAnswer(http_request.responseText);
                else
                {
                    var doc = null;
                    if(window.ActiveXObject)
                    {
                        //IE
                        doc = new ActiveXObject("Microsoft.XMLDOM");
                        doc.async="false";
                        doc.loadXML(http_request.responseText);
                    } else {
                        //FF
                        doc = new DOMParser().parseFromString(http_request.responseText,"text/xml");
                    }

                    var root = doc.documentElement;
                    var Content = root.getElementsByTagName("Content")[0];
                    this.OnAnswer(Content);
                }

                if(eval_javascript)
                    this.EvalJavaScript(http_request.responseText);
            }
        }
    }

    Ajax.prototype.EvalJavaScript = function(Content) {
      
      var scripts = Array();

      // Strip out tags
      while(Content.indexOf("<script") > -1 || Content.indexOf("</script") > -1) {
        var s = Content.indexOf("<script");
        var s_e = Content.indexOf(">", s);
        var e = Content.indexOf("</script", s);
        var e_e = Content.indexOf(">", e);

        // Add to scripts array
        scripts.push(Content.substring(s_e+1, e));
        // Strip from strcode
        Content = Content.substring(0, s) + Content.substring(e_e+1);
      }

      // Loop through every script collected and eval it
      for(var i=0; i<scripts.length; i++) {
        try {
          eval(scripts[i]);
        }
        catch(ex) {
          // do what you want here when a script fails
        }
      }
    }

}
