import ApiService from "@/Services/api.service.js";
import {StatusCodes} from 'http-status-codes'
import {BadRequestException} from "@/Exceptions/http.exceptions.js";


const QuestionService = {
    readQuestion: async function (id) {
        try {
            return await ApiService.get('/api/question/' + id).then(res => {
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

export default QuestionService
