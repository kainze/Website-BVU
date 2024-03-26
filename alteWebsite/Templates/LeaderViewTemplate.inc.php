<div align='center'><img src='Layout/GetHeadline.php5' alt="Vorstandschaft"></div><br>

<div id="imgLeaders">
<img src="Layout/Vorstandschaft.jpg" alt="Vorstandschaft">
</div>
<br><br>
<b>
    <a class="personPointerLink">Seppe Jetzlsperger, 1. Vorstand,</a><br>
    <a class="personPointerLink">Christoph Kainzmaier, 2. Vorstand</a><br>
    <a class="personPointerLink">Pfarrer Heribert Schauer, geistlicher Präses,</a><br>
    <br>
    <a class="personPointerLink">Andreas Mayr, 1. Kassier,</a><br>
    <a class="personPointerLink">Johannes Jändl, 2. Kassier,</a><br>
    <br>
    <a class="personPointerLink">Alex Salzinger, 1. Schriftführer,</a><br>
    <a class="personPointerLink">Michael Schneiderbauer, 2. Schriftführer,</a><br>
    <br>
    <a class="personPointerLink">Johannes Osl, 1. Fähnrich,</a><br>
    <a class="personPointerLink">Adrian Wolfswinkler, 2. Fähnrich,</a><br>
    <br>
    <a class="personPointerLink">Hans Huber, Passivbeauftragter</a><br>
    <br>
    <a class="personPointerLink">Matthias Handwerker, Beisitzer,</a><br>
    <a class="personPointerLink">Josef Langlechner, Beisitzer,</a><br>
    <a class="personPointerLink">Erich Zwirglmaier, Beisitzer,</a><br>
    <a class="personPointerLink">Thomas Kamhuber, Beisitzer</a><br>
</b>

<script type="text/javascript">

    //var personsXPos = new Array(400,201,620,525,400,300,350,490,175,720,220,450,600,690); - 175
    //var personsYPos = new Array(423,395,400,305,320,325,295,340,315,365,315,300,310,300); -170
    var personsXPos = new Array(225, 26, 445, 350, 225, 125, 175, 315, 0, 545, 45, 275, 425, 515);
    var personsYPos = new Array(253, 225, 230, 135, 150, 155, 125, 170, 145, 195, 145, 130, 140, 130);
    var personsDivs = new Array();
    var personsLinks = new Array();

    function showPersonPointers(pos)
    {
        if(pos == -1)
        {
            for(var i=0;i<personsDivs.length;i++)
            {
                personsDivs[i].className = "personPointer";
                personsLinks[i].className = "personPointLink";
            }
        }
        else
        {
            personsDivs[pos].className = "personPointerActive";
            personsLinks[pos].className = "personPointLinkActive";
        }
    }

    function init()
    {
        var links = document.getElementsByTagName("a");
        var pos=0;
        for(var i = 0;i<links.length;i++)
        {
            var link = links[i];

            if(link.className == "personPointerLink")
            {
                initPersonDivs(pos);
                initPersonPointerLink(link,pos);

                pos++;
            }
        }
    }

    function initPersonDivs(pos)
    {
        var x = personsXPos[pos];
        var y = personsYPos[pos]

        var div = document.createElement("div");
        div.className = "personPointer";
        div.style.left = x + "px";
        div.style.top = y + "px";
        div.onmouseover = function() { showPersonPointers(pos); };
        div.onmouseout = function() { showPersonPointers(-1); };

        personsDivs[pos] = div;
        var divImgLeaders = document.getElementById("imgLeaders");
        divImgLeaders.appendChild(div);
    }

    function initPersonPointerLink(link, pos)
    {
        personsLinks[pos] = link;
        link.onmouseover = function() { showPersonPointers(pos); };
        link.onmouseout = function() { showPersonPointers(-1); };
    }

    init();

</script>