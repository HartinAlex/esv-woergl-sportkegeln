import "./index.scss"

wp.blocks.registerBlockType("ourplugin/sportkegeln-liga-betrieb", {
    title: "Verwaltung Spiele",
    description: "Hier können die Spielpaarungen für die einzelnen Runden eingegeben werden",
    icon: "welcome-learn-more",
    category: "common",
    attributes: {
      roundId: {type: "string"},
      leagueId: {type: "string"},
    },
    edit: EditSpielplan,
    save: function () {
      return null
    }
  })

function EditSpielplan(props) {
 alert("Hier können die Spielpaarungen eingegeben werden.") 
}
