/**
 * Helpers for finding ticket state
 */
export function isUrgent(ticket) {
    return ticket.ticket_severity.level == 10
}

export function isUnassigned(ticket) {
    if(ticket.ticket_status.name == 'unassigned'){
        return ticket.ticket_severity.level != 10;
    }
    return false
}

export function isOpenTicket(ticket) {
    if(ticket.ticket_status.name != 'unassigned'){
        return ticket.ticket_severity.level != 10;
    }
    return false
}