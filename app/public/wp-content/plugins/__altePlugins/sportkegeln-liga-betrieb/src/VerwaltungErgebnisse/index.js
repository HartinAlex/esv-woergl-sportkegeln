import "./index.scss"

  wp.blocks.registerBlockType("ourplugin/sportkegeln-liga-betrieb", {
    title: "Verwaltung Ergebnisse",
    description: "Hier können die Spielpaarungen für die einzelnen Runden eingegeben werden",
    icon: "welcome-learn-more",
    category: "common",
    attributes: {
      roundId: {type: "string"},
      leagueId: {type: "string"},
    },
    edit: EditErgebnisse,
    save: function () {
      return null
    }
  })

function EditErgebnisse(props) {
  alert("Hier können die Ergebnisse eingetragen werden.") 
 }