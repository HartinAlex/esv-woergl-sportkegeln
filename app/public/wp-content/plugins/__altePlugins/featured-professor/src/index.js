import "./index.scss"
import {useSelect} from "@wordpress/data"

wp.blocks.registerBlockType("ourplugin/featured-professor", {
  title: "Professor Callout",
  description: "Include a short description and link to a professor of your choice",
  icon: "welcome-learn-more",
  category: "common",
  attributes: {
    profId: {type: "string"}
  },
  edit: EditComponent,
  save: function () {
    return null
  }
})

function EditComponent(props) {
  const allLeagues = useSelect(select => {
    return select("core").getEntityRecords("postType", "league", {per_page: -1})
  })

  console.log(allLeagues)

  if (allLeagues == undefined) return <p>Loading...</p>

  return (
    <div className="featured-professor-wrapper">
      <div className="professor-select-container">
        <select onChange={e => props.setAttributes({profId: e.target.value})}>
          <option value="">Wähle eine Liga</option>
          {allLeagues.map(league => {
            return (
              <option value={league.id} selected={props.attributes.profId == league.id}>
                {league.title.rendered}
              </option>
            )
          })}
        </select>
      </div>
      <div>
        The HTML preview of the selected professor will appear here.
      </div>
    </div>
  )
}