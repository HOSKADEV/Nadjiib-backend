
export const types = [
  {
    id: 1,
    title: "student",
    name: "التلميذ",
    color: "#007bff",
    img: "pages/src/assets/images/student.svg", // Relative path
  },
  {
    id: 2,
    title: "teacher",
    name: "الأستاذ",
    color: "#007bff",
    img: "pages/src/assets/images/teacher.svg", // Relative path
  },
];

export const faqData = [
  { id: 1,
    question: "ماهو نجيب؟",
    answer: "نجيب هو منصة تعليمية تقدم دورات وتدريب عبر الإنترنت لجميع المراحل الدراسية والمجالات، مع وجود أساتذة محترفين.",
    type: "general",
    color: "#007bff"
  },

    // Student specific questions
  { id: 2,
    question: "كيف يمكنني التسجيل في الدورات؟",
    answer: "يمكنك التسجيل في الدورات عبر إنشاء حساب على المنصة واختيار الدورة التي ترغب في الانضمام إليها.",
    type: "student",
    color: "#007bff",  // Blue for students
  },
  {
    id: 3,
    question: "هل تقدمون شهادات بعد انتهاء الدورات؟",
    answer: "نعم، نجيب يقدم شهادات معتمدة عند الانتهاء من الدورات بنجاح.",
    type: "student",
    color: "#007bff", // Blue for students
  },
  {
    id: 4,
    question: "هل الدورات مجانية؟",
    answer:
      "نقدم بعض الدورات المجانية بالإضافة إلى دورات مدفوعة بأسعار تنافسية.",
    type: "student",
    color: "#007bff", // Blue for students
  },
  {
    id: 5,
    question: "كيف يمكنني الوصول إلى الدورات التي سجلت فيها؟",
    answer:
      "يمكنك الوصول إلى الدورات من خلال صفحة 'الدورات الخاصة بي' بعد تسجيل الدخول.",
    type: "student",
    color: "#007bff", // Blue for students
  },

  // Teacher-specific questions
  {
    id: 6,
    question: "كيف يمكنني تقديم دورة كمدرّس؟",
    answer:
      "يمكنك تقديم طلب لتصبح مدرسًا على نجيب عن طريق إنشاء حساب وتعبئة نموذج المدرسين.",
    type: "teacher",
    color: "#007bff", // Blue color for teacher-related questions
  },
  {
    id: 7,
    question: "هل أحتاج إلى شهادات لتدريس الدورات؟",
    answer:
      "نعم، يجب أن تكون لديك شهادات معتمدة وخبرة في المجال الذي ترغب في تدريسه.",
    type: "teacher",
    color: "#007bff", // Blue for teachers
  },
  {
    id: 8,
    question: "كيف يمكنني إدارة الطلاب المسجلين في دورتي؟",
    answer:
      "بعد إنشاء الدورة، يمكنك إدارة الطلاب من خلال لوحة التحكم الخاصة بالمدرسين.",
    type: "teacher",
    color: "#007bff", // Blue for teachers
  },
  {
    id: 9,
    question: "كيف يمكنني إضافة محتوى جديد إلى الدورة؟",
    answer:
      "يمكنك إضافة دروس ومواد جديدة عبر لوحة التحكم الخاصة بالدورة في أي وقت.",
    type: "teacher",
    color: "#007bff", // Blue for teachers
  },
];
