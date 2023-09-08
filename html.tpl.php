<!doctype html>
<html>
    <head> 
        <meta http-equiv="content-type" content="text/html; charset=windows-1252" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js">
        </script>
        <!-- <base href="/" /> -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=yes" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="/node_modules/@ocdladefense/modal/src/css/loading.css" />
        <link rel="stylesheet" href="/node_modules/@ocdladefense/modal/src/css/modal.css" />
        <link rel="stylesheet" href="/node_modules/@ocdladefense/modal/src/css/inline-modal.css" />
        <link rel="stylesheet" href="/<?= $themeUrl ?>/css/main.css" />
        <link rel="stylesheet" href="/<?= $themeUrl ?>/css/citations.css" />
        <link rel="stylesheet" href="/<?= $themeUrl ?>/css/headings.css" />
        <link rel="stylesheet" href="/<?= $themeUrl ?>/css/toc.css" />
        <link rel="stylesheet" href="/<?= $themeUrl ?>/css/modal.css" />
        <link rel="stylesheet" href="/<?= $themeUrl ?>/css/tools.css" />
        <link rel="stylesheet" media="(min-width:767px)" href="/<?= $themeUrl ?>/css/desktop.css" />
        <script src="https://kit.fontawesome.com/c2278a45b9.js" crossorigin="anonymous">
        </script>

        <!--
        https://developers.google.com/maps/documentation/geocoding/requests-geocoding
        -->
        
        <script type="application/javascript">
            window.book = "<?= $book ?>";

        </script>
    </head>
    
    <body tab-index="-1">
        <?= $body ?>
    </body>

    <script type="module">

        // https://medium.com/streak-developer-blog/the-complexities-of-implementing-inline-autocomplete-for-content-editables-e358c0ed504b
        import ReadingContext from "/node_modules/@ocdladefense/reading-context/reading-context.js";
        import SearchClient from "/node_modules/@ocdladefense/search-client/search-client.js";
        import Autocomplete from "/node_modules/@ocdladefense/webc-autocomplete/autocomplete.js";
        import { WebcOrs } from "/node_modules/@ocdladefense/webc-ors/src/WebcOrs.js";
        import { WebcOar } from "/node_modules/@ocdladefense/webc-oar/src/WebcOar.js";
        import "/node_modules/@ocdladefense/html/html.js";
        import domReady from "/node_modules/@ocdladefense/web/src/web.js";
        // https://medium.com/streak-developer-blog/the-complexities-of-implementing-inline-autocomplete-for-content-editables-e358c0ed504b

        // customElements.define("word-count", WordCount, { extends: "p" });
        customElements.define("webc-autocomplete", Autocomplete);
        customElements.define("webc-ors", WebcOrs);
        customElements.define("webc-oar", WebcOar);

        window.init = init;
        domReady(init);

        async function init() {
            const terms = ['apple', 'cheese', "cantaloupe", 'apple watch', 'apple macbook', 'apple macbook pro', 'iphone', 'iphone 12'];

            
            let foo = await fetch("https://appdev.ocdla.org/search/query?r=ocdla_products&q=duii").then(resp => resp.json());
            foo = foo.map(result => result.title);
            // console.log(foo);
            const client = new SearchClient(foo);

            let autocomplete = document.getElementById("query");
            // console.log(autocomplete);
            autocomplete.source(client);
            autocomplete.addEventListener("search",function(e) {
                // Gets the search terms committed as part of the search.
                // e.detail.terms
            });
            autocomplete.addEventListener("beforedisplayresults",function(e) {

            });

            document.body.addEventListener("click",function(e) {
                console.log("Body event listener.");
                autocomplete.hide();
            });
        }
    </script>

    
    <script type="module" src="/js/init.js"></script> 
        
    <script type="module">
        import domReady from "/node_modules/@ocdladefense/web/src/web.js";



        window.addEventListener("hashchange", function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            
            let oldId = e.oldURL.split("#")[1];
            let newId = e.newURL.split("#")[1];

            console.log(newId);
            let newElem = document.getElementById(newId);


            newElem.scrollIntoView({behavior:"smooth", block:"center",inline:"nearest"});//({top: (rect.y + offset),behavior:"smooth"});
        });

        const courts = {
            "Or": "Oregon Supreme Court",
            "Or App": "Oregon Appellate Court",
            "S Ct": "United State Supreme Court"
        };
    
        const reporters = {
            "S Ct": "3,38",
            "Or": "Oregon Supreme Court",
            "Or App": "Oregon Appellate Court",
            "S Ct": "United State Supreme Court"
        };


        let refContainer = document.querySelector("#all-refs");
        let cites = document.querySelectorAll(".cite");

        domReady(function() {
            formatReferences();
            
            doRefs();
        });


        function parseRef(ref) {

            let parts = ref.split(" ");
            let vol = parts.shift().trim();
            let page = parts.pop().trim();
            let reporter = parts.join(" ");
            let year = "(2008)";
            return { vol, reporter, page };
        }

        function* getReporters(str) {
            let parts = str.split(/[\,]/).map((ref) => ref.trim());
            parts.shift();
            let yielded = [];
            for (var i = parts.length - 1; i >= 0; i--) {
                if (!isNaN(parts[i].replace(/[\-]/, ""))) {
                    yielded.unshift(parts[i]);
                    continue;
                }
                else {
                    yielded.unshift(parts[i]);

                    yield yielded.splice(0).join(", ");
                }
            }
        };

        function formatReferences() {
            for (var i = 0; i < cites.length; i++) {
                let n = cites[i];
                // console.log(n);
                let href = n.getAttribute("href");
                let str = n.innerText;
                let parts = str.split(",");
                let caseName = parts.shift();


                let reporting = [...getReporters(str)].reverse();
                // console.log(reporting);
                let reportingText = reporting.join(", ");


                let query = reporting[0] && reporting[0].split(",")[0];

                // continue;
                // https://scholar.google.com/scholar?as_sdt=3,38&q=+118+S+Ct+1952&hl=en


                let link = n.cloneNode(false);
                let replace = document.createElement("span");
                // href = null;
                href = href || ("https://scholar.google.com/scholar?hl=en&as_sdt=4,38,60,156&q=" + query);
                link.setAttribute("href", href);
                link.setAttribute("target", "_new");
                link.setAttribute("title", "View " + caseName + " in Google Scholar");
                link.setAttribute("references", [caseName, reportingText].join(", "));
                link.setAttribute("id", hashCaseName(caseName));

                // Pennsylvania Dept. Correction v. Yeskey
                link.appendChild(document.createTextNode(caseName));
                replace.appendChild(link);
                replace.appendChild(document.createTextNode(", " + reportingText));
                // console.log(n);
                n.parentNode.replaceChild(replace, n);
            }
        }


        function hashCaseName(name) {
            return name.replaceAll(/[\.\s\']/gis, "");
        }
        

        function doRefs() {
            const refs = document.querySelectorAll("[references], .cite");

            let container = document.createElement("ul");

            for (var i = 0; i < refs.length; i++) {

                let n = refs[i];
                let id = refs[i].getAttribute("id");
                n.setAttribute("target", "_new");

                let a = document.createElement("a");
                let bullet = document.createElement("li");
                let text = n.getAttribute("references");
                a.setAttribute("class", "reference");
                let label = document.createTextNode(text);
                a.appendChild(label);
                a.setAttribute("href", "#"+n.getAttribute("id"));
                bullet.appendChild(a);
                container.appendChild(bullet);
            }

            refContainer.appendChild(container);
        }


    </script>

    <script type="module">

        import { Modal } from "/node_modules/@ocdladefense/modal/dist/modal.js";
        window.loadToc = loadToc;
        function loadToc() {
            let config = {
                style: "display:block; width:auto; vertical-align:top; overflow-x: hidden; overflow-y: auto; height:60vh; padding: 8px;"
            };
            let modal = new Modal(config);
            modal.show();
            fetch("/sites/pubs.ocdla.org/books/"+window.book+"/toc.tpl.php").then((resp) => {
                return resp.text();
            })
            .then((html) => {
                modal.render(html);
            });
        }
    </script>
    <script type="module">

        import domReady from "/node_modules/@ocdladefense/web/src/web.js";
        import { DomDocument } from "/node_modules/@ocdladefense/dom/src/DomDocument.js";
        

        domReady(init);

        // Use these headings to create an on-the-fly outline of the document.
        function init() {
            let doc = new DomDocument();
            let nodes = doc.outline(".mw-headline");
            nodes.forEach((node) => document.querySelector(".outline-content").appendChild(node));
        }

    </script>


</html>