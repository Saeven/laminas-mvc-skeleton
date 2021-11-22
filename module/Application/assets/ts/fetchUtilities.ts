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
}