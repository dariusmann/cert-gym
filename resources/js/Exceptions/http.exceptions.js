class BadRequestException extends Error {
    constructor (errorCode, message) {
        super(message)
        this.name = this.constructor.name
        this.message = message
        this.errorCode = errorCode
    }
}

class UnexpectedServerError extends Error {
    constructor (errorCode, message) {
        super(message)
        this.name = this.constructor.name
        this.message = message
        this.errorCode = errorCode
    }
}

export { BadRequestException, UnexpectedServerError }
