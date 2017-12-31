/**
 * Helpers for finding task state
 */
export function isUrgent(task) {
    return task.priority.level == 10
}

export function isUnassigned(task) {
    if(task.status.name == 'unassigned'){
        return task.priority.level != 10;
    }
    return false
}

export function isOpenTask(task) {
    if(task.status.name != 'unassigned'){
        return task.priority.level != 10;
    }
    return false
}