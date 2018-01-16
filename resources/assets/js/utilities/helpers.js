/**
 * Helpers for finding task state
 */
export function isHighPriority(task) {
    return task.priority.level >= 8;
}

export function isUnassigned(task) {
    if (task.assigned_user == null) {
      return task.priority.level <= 7;
    }
    return false
}

export function isOpenTask(task) {
    if (task.assigned_user != null) {
      return task.priority.level <= 7;
    }
    return false
}