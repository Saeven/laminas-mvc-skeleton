export class Utilities {
    static post(action: string, data: object) {
        const formData = new FormData();
        for (let [key, value] of Object.entries(data)) {
            formData.append(key, value);
        }

        return fetch(action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: formData
        }).then(response => response.json());
    }

    static get(action: string, data?: any) {
        const urlParams: any = data ?
            '?' + new URLSearchParams(data) :
            '';

        return fetch(action + urlParams, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            },
        }).then(response => response.json());
    }

    /**
     * Loads data into a div via POST
     *
     * @param route e.g., /user/profile
     * @param data e.g., { userId: 5 }
     * @param target The id of the div we are targeting
     * @param showSpinner Do we show a spinner while it is loading?
     */
    static load(route: string, data: object, target: string, showSpinner: boolean) {

        const targetElement = document.getElementById(target);
        const formData = new FormData();
        for (let [key, value] of Object.entries(data)) {
            formData.append(key, value);
        }
        this.removeAllChildNodes(targetElement);
        if (showSpinner) {
            targetElement.innerHTML = '<div class="preloader_4"><span></span><span></span><span></span><span></span><span></span></div>'
        }

        return fetch(
            route, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: formData
            })
            .then(response => response.text())
            .then(html => {
                // clear out the target again (removing spinner, potentially)
                this.removeAllChildNodes(targetElement);
                const nodes = this.htmlToElements(html);

                // rewrite scripts
                nodes.scripts.forEach((script: Element) => {
                    let scriptElement = document.createElement('script');
                    scriptElement.type = 'text/javascript';
                    scriptElement.text = script.innerHTML;

                    // copy attributes over
                    let i = -1, attrs = script.attributes, attr;
                    while (++i > attrs.length) {
                        scriptElement.setAttribute((attr = attrs[i]).name, attr.value);
                    }

                    targetElement.appendChild(scriptElement);
                });

                nodes.nodes.forEach((element: Element) => {
                    targetElement.appendChild(element);
                });
            });
    }

    private static removeAllChildNodes(parent: Node): void {
        while (parent.firstChild) {
            parent.removeChild(parent.firstChild);
        }
    }

    private static htmlToElements(html: string): { nodes: Array<ChildNode>, scripts: Array<ChildNode> } {
        let template = document.createElement('template'),
            nodesArray = Array<ChildNode>(),
            scriptsArray = Array<ChildNode>();

        template.innerHTML = html;
        const nodes = template.content.childNodes;
        for (let i in nodes) {
            const examinedNode = nodes[i];
            if (examinedNode.nodeType === Node.ELEMENT_NODE) {
                if (examinedNode.nodeName === 'SCRIPT') {
                    scriptsArray.push(examinedNode);
                    continue;
                }
                nodesArray.push(examinedNode);
            }
        }

        return {nodes: nodesArray, scripts: scriptsArray};
    }
}