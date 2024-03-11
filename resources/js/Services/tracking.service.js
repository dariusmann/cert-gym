import ApiService from "@/Services/api.service.js";
import {StatusCodes} from 'http-status-codes'
import {BadRequestException} from "@/Exceptions/http.exceptions.js";


const TrackingService = {
    readAccuracyRateStats: async function () {
        try {
            return await ApiService.get('/api/tracking/accuracy').then(res => {
                return res.data
            })
        } catch (error) {
            if (error.response.status === StatusCodes.BAD_REQUEST) {
                throw new BadRequestException(error)
            }

            throw error
        }
    },
    readCategoriesAccuracyRateStats: async function () {
        try {
            return await ApiService.get('/api/tracking/categories/accuracy').then(res => {
                return res.data
            })
        } catch (error) {
            if (error.response.status === StatusCodes.BAD_REQUEST) {
                throw new BadRequestException(error)
            }

            throw error
        }
    },
}

export default TrackingService
