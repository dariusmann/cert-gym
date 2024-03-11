import ApiService from "@/Services/api.service.js";
import {StatusCodes} from 'http-status-codes'
import {BadRequestException} from "@/Exceptions/http.exceptions.js";


const QuestionRunService = {
    readRandomRun: async function () {
        try {
            return await ApiService.get('/api/question/run/random').then(res => {
                return res.data
            })
        } catch (error) {
            if (error.response.status === StatusCodes.BAD_REQUEST) {
                throw new BadRequestException(error)
            }

            throw error
        }
    },
    createCategoryRun: async function (categoriesIds) {
        try {
            return await ApiService.post('/api/question/run/category', {
                category_ids: categoriesIds
            }).then(res => {
                return res.data
            })
        } catch (error) {
            if (error.response.status === StatusCodes.BAD_REQUEST) {
                throw new BadRequestException(error)
            }

            throw error
        }
    },
    readQuestionRun: async function () {
        try {
            return await ApiService.get('/api/user/question/run').then(res => {
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

export default QuestionRunService
