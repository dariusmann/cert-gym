import ApiService from "@/Services/api.service.js";
import {StatusCodes} from 'http-status-codes'
import {BadRequestException} from "@/Exceptions/http.exceptions.js";


const QuestionAttemptService = {
    createRunQuestionAttempt: async function (data) {
        try {
            return await ApiService.post('/api/question/run/attempt',
                data
            ).then(res => {
                return res.data
            })
        } catch (error) {
            if (error.response.status === StatusCodes.BAD_REQUEST) {
                throw new BadRequestException(error)
            }

            throw error
        }
    },
    createRunQuestionExamAttempt: async function (data) {
        try {
            return await ApiService.post('/api/question/run/exam/attempt',
                data
            ).then(res => {
                return res.data
            })
        } catch (error) {
            if (error.response.status === StatusCodes.BAD_REQUEST) {
                throw new BadRequestException(error)
            }

            throw error
        }
    },
    readQuestionAttempt: async function (attemptId) {
        try {
            return await ApiService.get('/api/question/attempt/' + attemptId + '/answers').then(res => {
                return res.data
            })
        } catch (error) {
            if (error.response.status === StatusCodes.BAD_REQUEST) {
                throw new BadRequestException(error)
            }

            throw error
        }
    },
    createQuestionExamFlag: async function (runQuestionId) {
        try {
            return await ApiService.post('/api/question/run/exam/flag', {
                run_question_id: runQuestionId
            }).then(res => {
                return res.data
            })
        } catch (error) {
            if (error.response.status === StatusCodes.BAD_REQUEST) {
                throw new BadRequestException(error)
            }

            throw error
        }
    }
}

export default QuestionAttemptService
