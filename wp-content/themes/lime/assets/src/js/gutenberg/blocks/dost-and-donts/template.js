const getBlockColumns = (optionVal, colClassName, heading) => {
  return [
    "core/column",
    {
      className: colClassName,
    },
    [
      [
        "yoyo-blocks/heading-with-icon",
        {
          className: "yoyo-dos-and-donts__heading",
          option: optionVal,
          content: heading,
        },
      ],
      [
        "core/list",
        {
          className: "yoyo-dos-and-donts__list",
        },
      ],
    ],
  ];
};

const innerBlockColumns = [
  [
    "core/columns", // Use a core/columns block
    {
      className: "yoyo-dos-and-donts__cols", // Add a custom class
    },
    [
      getBlockColumns("dos", "yoyo-dos-and-donts__col-one", "DOS"),
      getBlockColumns("donts", "yoyo-dos-and-donts__col-two", "DONTS"),
    ],
  ],
];

export default innerBlockColumns;
