export class EventEmitter {
    constructor() {
      this.events = {}; // Словарь для хранения событий и их обработчиков
    }
  
    // Метод для подписки на событие
    on(eventName, listener) {
      if (!this.events[eventName]) {
        this.events[eventName] = []; // Инициализируем массив обработчиков для нового события
      }
      this.events[eventName].push(listener); // Добавляем обработчик события
    }
  
    // Метод для вызова события
    emit(eventName, ...args) {
      if (this.events[eventName]) {
        this.events[eventName].forEach(listener => {
          listener(...args); // Вызываем все привязанные обработчики с аргументами
        });
      }
    }
  
    // Метод для удаления подписчика на событие
    off(eventName, listener) {
      if (this.events[eventName]) {
        this.events[eventName] = this.events[eventName].filter(l => l !== listener);
      }
    }
  }