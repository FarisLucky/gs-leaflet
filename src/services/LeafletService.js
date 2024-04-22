import { http, BASE_URL } from "@/config/http"

class LeafletService {

    constructor(httpConst) {
        this.http = httpConst
        this.url = "/fr-leaflet"
    }

    async all() {
        try {

            const { data } = await this.http.get(this.url)

            return [null, data]
        } catch (error) {
            return [error]
        }
    }

    async show(id) {
        try {

            const { data } = await this.http.get(this.url + '/show/' + id)

            return [null, data]
        } catch (error) {
            return [error]
        }
    }

    async pdf(id) {
        try {

            const { data } = await this.http.get(this.url + '/show-pdf/' + id, { responseType: 'blob' })

            return [null, data]
        } catch (error) {
            return [error]
        }
    }

    async detailImage(id) {
        try {

            const { data } = await http.get(this.url + `/show/${id}`)

            let pages = []

            if (data.data.length < 1) {
                throw new Error('Leaflet Gagal dimuat')
            }

            data.data.forEach((item) => {
                pages.push(BASE_URL + 'leaflet/view-leaflet/' + item.id);
            });

            return [null, pages]
        } catch (error) {
            return [error]
        }
    }

    async search(name) {
        try {

            const { data } = await http.get(this.url + `/list?q=${name}`)

            if (data.data.length < 1) {
                throw new Error('Leaflet Gagal dimuat')
            }

            return [null, data]
        } catch (error) {
            return [error]
        }
    }

    async showLeaflet(id) {
        try {

            const { data } = await http.get(this.url + `/show-leaflet/${id}`)

            return [null, data]
        } catch (error) {
            return [error]
        }
    }
}

export const leafletService = new LeafletService(http)