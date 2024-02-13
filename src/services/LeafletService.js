import { http } from "@/config/http"

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
}

export const leafletService = new LeafletService(http)