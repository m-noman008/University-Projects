import React from 'react'
import list from "../../public/list.json"
export default function Freebook() {
  const filterdata= list.filter((data)=>data.catagory==="Free");
  console.log(filterdata);
  return (
    <>
      <div className="max-w-screen-2xl container mx-auto md:px-20 px-4">
          <h1 className="font text-xl pb-2">
            Free Offered Courses
          </h1>
      </div>
    </>
  )
}
